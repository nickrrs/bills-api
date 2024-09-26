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
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;

class GoalController extends Controller
{
    use ExceptionHandler;

    public function __construct(private GoalService $goalService)
    {

    }

    public function index(Request $request): ResourceCollection | JsonResponse
    {
        try {
            $activeAccount = $request->user()->activeAccount();

            if(!filled($activeAccount)) {
                return response()->json([
                    'error' => [
                        'message' => 'Please select an account.',
                    ],
                ]);
            }

            $goals = $this->goalService->index($activeAccount);
            $closestExpiringGoal = Goal::closestExpiringGoal();
            $totalInvested = Goal::totalInvested();
            $totalGoals = Goal::totalGoals();

            return GoalResource::collection($goals)->additional([
                'closest_expiring_goal' => $closestExpiringGoal,
                'total_invested'        => $totalInvested,
                'total_goals'           => $totalGoals
            ]);
        } catch (Exception $exception) {
            Log::error('Error while listing goals: ', ['error' => $exception->getMessage(), 'status' => $exception->getCode()]);

            return $this->handleException($exception);
        }
    }

    public function show(Goal $goal): GoalResource | JsonResponse
    {
        try {
            return new GoalResource($goal->load(['account']));
        } catch (Exception $exception) {
            Log::error('Error while index goal: ', ['error' => $exception->getMessage(), 'status' => $exception->getCode()]);

            return $this->handleException($exception);
        }
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

    public function destroy(Goal $goal): JsonResponse
    {
        try {
            $deleted = $this->goalService->destroy($goal);

            if(!$deleted) {
                return response()->json([
                    'error' => [
                        'message' => 'Error while trying deleting the goal, please try again.',
                    ],
                ], 409);
            }

            return response()->json([
                'success' => [
                    'message' => 'Goal deleted.',
                ],
            ]);
        } catch (Exception $exception) {
            Log::error('Error while deletinng goal: ', ['error' => $exception->getMessage(), 'status' => $exception->getCode()]);

            return $this->handleException($exception);
        }
    }
}
