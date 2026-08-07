<?php

namespace App\DTOs;

use App\Http\Requests\UpdateRoomStatusRequest;

class UpdateRoomStatusData
{
    public function __construct(
        public readonly string $status,
    ) {}

    public static function fromRequest(UpdateRoomStatusRequest $request): self
    {
        return new self(
            status: $request->input('status'),
        );
    }
}
