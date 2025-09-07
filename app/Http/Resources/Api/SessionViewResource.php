<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionViewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'venue' => $this->venue,
            'detail' => $this->detail,
            'schedules' => $this->schedules,
            'participants' => $this->participants,
            'status' => $this->status,
            'activities' => $this->activities,
            'managers' => $this->managers,
            'event' => $this->event,
            'has_registered' => $this->has_registered,
            'feedbackable' => FeedbackResource::collection($this->feedbackable),
            'questions' => QuestionResource::collection($this->questions)
        ];
    }
}
