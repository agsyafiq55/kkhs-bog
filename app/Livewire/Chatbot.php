<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use App\Models\AcademicAchievement;
use App\Models\Announcement;
use App\Models\CocurricularAchievement;
use App\Models\ContactUs;
use App\Models\Member;
use App\Models\TimelineCard;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class Chatbot extends Component
{
    public $userInput = '';
    public $lastUserInput = '';
    public $response = '';
    public $conversationHistory = [];
    
    protected function getRelevantDatabaseContext($query)
    {
        $context = [];
        $foundData = false;
        $lowerQuery = strtolower($query);
        
        // Get upcoming events if asking about events
        if (str_contains($lowerQuery, 'event') || 
            str_contains($lowerQuery, 'coming up') || 
            str_contains($lowerQuery, 'calendar') || 
            str_contains($lowerQuery, 'schedule')) {
            
            // Get upcoming events (events with dates equal to or after today)
            $upcomingEvents = Event::where('event_date', '>=', Carbon::now()->format('Y-m-d'))
                ->orderBy('event_date', 'asc')
                ->limit(5)
                ->get();
                
            if ($upcomingEvents->isNotEmpty()) {
                $context[] = "# Upcoming Events at KKHS:";
                foreach ($upcomingEvents as $event) {
                    $eventDate = Carbon::parse($event->event_date)->format('d F Y');
                    $context[] = "## {$event->title}";
                    $context[] = "- **Date**: {$eventDate}";
                    $context[] = "- **Category**: " . ($event->tag ?: 'General');
                    $context[] = "- **Details**: " . Str::limit($event->description, 150);
                    $context[] = "";
                }
                $foundData = true;
            }
            
            // Get recent past events (events from the last 30 days)
            $recentEvents = Event::where('event_date', '<', Carbon::now()->format('Y-m-d'))
                ->where('event_date', '>=', Carbon::now()->subDays(30)->format('Y-m-d'))
                ->orderBy('event_date', 'desc')
                ->limit(3)
                ->get();
                
            if ($recentEvents->isNotEmpty()) {
                $context[] = "# Recent Events at KKHS:";
                foreach ($recentEvents as $event) {
                    $eventDate = Carbon::parse($event->event_date)->format('d F Y');
                    $context[] = "## {$event->title}";
                    $context[] = "- **Date**: {$eventDate}";
                    $context[] = "- **Category**: " . ($event->tag ?: 'General');
                    $context[] = "- **Details**: " . Str::limit($event->description, 150);
                    $context[] = "";
                }
                $foundData = true;
            }
        }
        
        // Search for specific events based on keywords
        if (!$foundData || !str_contains($lowerQuery, 'upcoming')) {
            $searchEvents = Event::where('title', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->orWhere('article', 'like', "%{$query}%")
                ->orWhere('tag', 'like', "%{$query}%")
                ->orderBy('event_date', 'desc')
                ->limit(3)
                ->get();
                
            if ($searchEvents->isNotEmpty()) {
                $context[] = "# Events matching your query:";
                foreach ($searchEvents as $event) {
                    $eventDate = Carbon::parse($event->event_date)->format('d F Y');
                    $context[] = "## {$event->title}";
                    $context[] = "- **Date**: {$eventDate}";
                    $context[] = "- **Category**: " . ($event->tag ?: 'General');
                    $context[] = "- **Details**: " . Str::limit($event->description, 150);
                    $context[] = "";
                }
                $foundData = true;
            }
        }
        
        // Search in academic achievements
        if (str_contains($lowerQuery, 'academic') || 
            str_contains($lowerQuery, 'exam') || 
            str_contains($lowerQuery, 'spm') || 
            str_contains($lowerQuery, 'stpm') ||
            str_contains($lowerQuery, 'achievement')) {
            
            $academicAchievements = AcademicAchievement::where('exam_type', 'like', "%{$query}%")
                ->orWhere('year', 'like', "%{$query}%")
                ->orderBy('year', 'desc')
                ->limit(5)
                ->get();
                
            if ($academicAchievements->isNotEmpty()) {
                $context[] = "# Academic Achievements:";
                foreach ($academicAchievements as $achievement) {
                    $context[] = "## {$achievement->exam_type} Results ({$achievement->year})";
                    $context[] = "- **GPS (Grade Point Score)**: {$achievement->gps}";
                    $context[] = "- **Certificate Qualification Rate**: {$achievement->certificate_percentage}%";
                    $context[] = "";
                }
                $foundData = true;
            }
            
            // Get latest year's academic performance
            $latestYear = AcademicAchievement::max('year');
            if ($latestYear) {
                $spmStats = AcademicAchievement::where('year', $latestYear)
                    ->where('exam_type', 'SPM')
                    ->first();
                    
                $stpmStats = AcademicAchievement::where('year', $latestYear)
                    ->where('exam_type', 'STPM')
                    ->first();
                    
                if ($spmStats || $stpmStats) {
                    $context[] = "# Latest Academic Performance ({$latestYear}):";
                    if ($spmStats) {
                        $context[] = "## SPM Results";
                        $context[] = "- **GPS**: {$spmStats->gps}";
                        $context[] = "- **Certificate Qualification Rate**: {$spmStats->certificate_percentage}%";
                        $context[] = "";
                    }
                    if ($stpmStats) {
                        $context[] = "## STPM Results";
                        $context[] = "- **GPS**: {$stpmStats->gps}";
                        $context[] = "- **Certificate Qualification Rate**: {$stpmStats->certificate_percentage}%";
                        $context[] = "";
                    }
                    $foundData = true;
                }
            }
        }
        
        // Search in announcements
        if (str_contains($lowerQuery, 'announcement') || 
            str_contains($lowerQuery, 'news') || 
            str_contains($lowerQuery, 'update') || 
            str_contains($lowerQuery, 'notice')) {
            
            $announcements = Announcement::where(function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                    ->orWhere('content', 'like', "%{$query}%");
                })
                ->where(function($q) {
                    $now = now();
                    $q->whereNull('publish_start')
                    ->orWhere('publish_start', '<=', $now);
                })
                ->where(function($q) {
                    $now = now();
                    $q->whereNull('publish_end')
                    ->orWhere('publish_end', '>=', $now);
                })
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->orderBy('published_at', 'desc')
                ->limit(5)
                ->get();
                
            if ($announcements->isNotEmpty()) {
                $context[] = "# Board of Governors Announcements:";
                foreach ($announcements as $announcement) {
                    $publishDate = $announcement->published_at->format('d F Y');
                    $context[] = "## {$announcement->title}";
                    $context[] = "- **Published**: {$publishDate}";
                    $context[] = "- **Details**: " . Str::limit(strip_tags($announcement->content), 200);
                    $context[] = "";
                }
                $foundData = true;
            }
        }
        
        // Search in cocurricular achievements
        if (str_contains($lowerQuery, 'cocurricular') || 
            str_contains($lowerQuery, 'co-curricular') || 
            str_contains($lowerQuery, 'extracurricular') || 
            str_contains($lowerQuery, 'achievement') || 
            str_contains($lowerQuery, 'competition') || 
            str_contains($lowerQuery, 'award') || 
            str_contains($lowerQuery, 'student achievement')) {
            
            $cocurricularAchievements = CocurricularAchievement::where('event_title', 'like', "%{$query}%")
                ->orWhere('category', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->orderBy('event_date', 'desc')
                ->limit(5)
                ->get();
                
            if ($cocurricularAchievements->isNotEmpty()) {
                $context[] = "# Cocurricular Achievements:";
                foreach ($cocurricularAchievements as $achievement) {
                    $eventDate = $achievement->event_date ? Carbon::parse($achievement->event_date)->format('d F Y') : 'Not specified';
                    $context[] = "## {$achievement->event_title}";
                    $context[] = "- **Category**: {$achievement->category}";
                    $context[] = "- **Date**: {$eventDate}";
                    $context[] = "- **Description**: " . Str::limit($achievement->description, 150);
                    
                    // Get achievement items if any
                    $items = $achievement->items;
                    if ($items && $items->count() > 0) {
                        $context[] = "- **Achievements**:";
                        foreach ($items as $item) {
                            $context[] = "  - {$item->achievement}";
                        }
                    }
                    
                    $context[] = "";
                }
                $foundData = true;
            }
        }
        
        // Search for contact information
        if (str_contains($lowerQuery, 'contact') || 
            str_contains($lowerQuery, 'email') || 
            str_contains($lowerQuery, 'phone') || 
            str_contains($lowerQuery, 'address') || 
            str_contains($lowerQuery, 'location') || 
            str_contains($lowerQuery, 'reach') || 
            str_contains($lowerQuery, 'call')) {
            
            $contactInfo = ContactUs::first();
            if ($contactInfo) {
                $context[] = "# Contact Information for KKHS Board of Governors:";
                $context[] = "- **Address**: {$contactInfo->address}";
                $context[] = "- **Email**: {$contactInfo->email}";
                if ($contactInfo->phone_no1) {
                    $context[] = "- **Phone 1**: {$contactInfo->phone_no1}";
                }
                if ($contactInfo->phone_no2) {
                    $context[] = "- **Phone 2**: {$contactInfo->phone_no2}";
                }
                $context[] = "";
                $foundData = true;
            }
        }
        
        // Get information about Board of Governors members
        if (str_contains($lowerQuery, 'board') || 
            str_contains($lowerQuery, 'governor') || 
            str_contains($lowerQuery, 'committee') || 
            str_contains($lowerQuery, 'member') || 
            str_contains($lowerQuery, 'chairman') || 
            str_contains($lowerQuery, 'who')) {
            
            // Get the latest year for which we have members
            $latestYear = Member::max('year');
            
            if ($latestYear) {
                $members = Member::where('year', $latestYear)
                    ->orderBy('position')
                    ->get();
                    
                if ($members->isNotEmpty()) {
                    $context[] = "# KKHS Board of Governors Members ({$latestYear}):";
                    foreach ($members as $member) {
                        $context[] = "## {$member->member_name}";
                        $context[] = "- **Position**: {$member->position}";
                        if ($member->zh_member_name) {
                            $context[] = "- **Chinese Name**: {$member->zh_member_name}";
                        }
                        $context[] = "";
                    }
                    $foundData = true;
                }
            }
        }
        
        // Get history/timeline information
        if (str_contains($lowerQuery, 'history') || 
            str_contains($lowerQuery, 'timeline') || 
            str_contains($lowerQuery, 'journey') || 
            str_contains($lowerQuery, 'when') || 
            str_contains($lowerQuery, 'founded') || 
            str_contains($lowerQuery, 'established') || 
            str_contains($lowerQuery, 'background')) {
            
            $timelineCards = TimelineCard::orderBy('year')
                ->get();
                
            if ($timelineCards->isNotEmpty()) {
                $context[] = "# KKHS Board of Governors History Timeline:";
                foreach ($timelineCards as $card) {
                    $context[] = "## {$card->year}";
                    $context[] = $card->description;
                    $context[] = "";
                }
                $foundData = true;
            }
        }
        
        // Generate disclaimer if no data was found
        if (!$foundData) {
            $context[] = "# No matching data found in KKHS database";
            $context[] = "Our database does not contain specific information matching your query. Please try asking about:";
            $context[] = "- Upcoming events at KKHS";
            $context[] = "- Board of Governors announcements";
            $context[] = "- Academic achievements";
            $context[] = "- Cocurricular achievements of students";
            $context[] = "- Contact information for KKHS";
            $context[] = "- Board of Governors members";
            $context[] = "- History of KKHS Board of Governors";
        }
        
        return implode("\n", $context);
    }
    
    public function sendMessage()
    {
        if (empty($this->userInput)) {
            $this->response = 'Please enter a message.';
            return;
        }
        
        // Store the current input before clearing it
        $this->lastUserInput = $this->userInput;
        
        try {
            // Get relevant database context
            $databaseContext = $this->getRelevantDatabaseContext($this->userInput);
            
            // Prepare the system message with instructions
            $systemMessage = "You are KKHS ChatBot, a helpful assistant for Kota Kinabalu High School (KKHS) Board of Governors website. " .
                           "VERY IMPORTANT: Only provide information that is explicitly present in the database context provided. " .
                           "DO NOT make up or invent any events, dates, or data that is not in the database context. " .
                           "If the provided database context says 'No matching data found', acknowledge this to the user and suggest " .
                           "they try asking about other topics like upcoming events or academic achievements. " .
                           "Format your response nicely using markdown, with proper headings, bullet points and emphasis where appropriate. " .
                           "Always maintain a friendly, helpful tone appropriate for a school website assistant." .
                           "DO NOT ever mention about the database to the user";
            
            // Add previous messages to maintain conversation context
            $messages = [
                ['role' => 'system', 'content' => $systemMessage],
                ['role' => 'user', 'content' => "Here is the KKHS database information:\n\n" . $databaseContext],
                ['role' => 'user', 'content' => $this->userInput]
            ];
            
            // Add conversation history for context (limit to last 4 exchanges)
            if (!empty($this->conversationHistory)) {
                $limitedHistory = array_slice($this->conversationHistory, -4, 4);
                $messages = array_merge([['role' => 'system', 'content' => $systemMessage]], $limitedHistory, [
                    ['role' => 'user', 'content' => "Here is the latest KKHS database information:\n\n" . $databaseContext],
                    ['role' => 'user', 'content' => $this->userInput]
                ]);
            }
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
                'HTTP-Referer' => env('APP_URL'),
                'X-Title' => env('APP_NAME'),
                'Content-Type' => 'application/json',
            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => env('OPENROUTER_MODEL'),
                'messages' => $messages
            ]);

            $data = $response->json();
            
            if (isset($data['choices'][0]['message']['content'])) {
                $markdownText = $data['choices'][0]['message']['content'];
                // Store the raw markdown content
                $this->response = $markdownText;
                
                // Save to conversation history
                $this->conversationHistory[] = ['role' => 'user', 'content' => $this->userInput];
                $this->conversationHistory[] = ['role' => 'assistant', 'content' => $markdownText];
                
                // Dispatch event with the response content
                $this->dispatch('chatResponse', $markdownText);
            } else {
                $this->response = 'No response received or unexpected response format.';
            }
            
        } catch (\Exception $e) {
            $this->response = 'Error: ' . $e->getMessage();
        }
        
        // Clear input after sending
        $this->userInput = '';
    }
    
    public function resetChat()
    {
        $this->userInput = '';
        $this->lastUserInput = '';
        $this->response = '';
        $this->conversationHistory = [];
        
        $this->dispatch('chatReset');
    }

    public function render()
    {
        return view('livewire.chatbot');
    }
}