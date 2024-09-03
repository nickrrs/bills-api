<?php

namespace App\Http\Controllers\API\V1\Tracks;

use App\Http\Controllers\Controller;
use App\Http\DTO\Tracks\Goal\{GoalDTO, UpdateGoalDTO};
use App\Http\Requests\Goal\{StoreGoalRequest, UpdateGoalRequest};
use App\Http\Resources\GoalResource;
use App\Models\Goal;
use App\Services\Tracks\GoalService;
use App\Traits\ExceptionHandler;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class GoalController extends Controller
{
    use ExceptionHandler;

    public function __construct(private GoalService $goalService)
    {

    }

    public function store(StoreGoalRequest $storeGoalRequest): GoalResource | JsonResponse
    {
        try {
            $activeAccount = $storeGoalRequest->user()->activeAccount();

            if(!filled($activeAccount)) {
                return response()->json([
                    'error' => [
                        'message' => 'Please select an account before creating a goal.',
                    ],
                ]);
            }

            $goalDTO             = new GoalDTO($storeGoalRequest->validated());
            $goalDTO->account_id = $activeAccount->id;

            $goal = $this->goalService->store($goalDTO);

            return new GoalResource($goal->load(['account']));
        } catch (Exception $exception) {
            Log::error('Error while registering new goal: ', ['error' => $exception->getMessage(), 'status' => $exception->getCode()]);

            return $this->handleException($exception);
        }
    }

    public function update(UpdateGoalRequest $updateGoalRequest, Goal $goal): GoalResource | JsonResponse
    {
        try {
            $goalDTO = new UpdateGoalDTO(
                $updateGoalRequest->validated(),
                $goal->toArray()
            );

            $goal = $this->goalService->update($goal, $goalDTO);

            return new GoalResource($goal->load(['account']));
        } catch (Exception $exception) {
            Log::error('Error while updating a goal: ', ['error' => $exception->getMessage(), 'status' => $exception->getCode()]);

            return $this->handleException($exception);
        }
    }
}
