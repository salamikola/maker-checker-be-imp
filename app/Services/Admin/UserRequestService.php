<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\AcceptUserRequest;
use App\Http\Requests\Admin\CreateUserResouceRequest;
use App\Http\Requests\Admin\RejectUserRequest;
use App\Models\Admin;
use App\Models\MakerChecker;
use App\Models\User;
use App\Notifications\UserCreateRequestNotification;
use App\Services\ServiceResponse;
use App\Traits\NotificationTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRequestService
{
    use NotificationTrait;

    public function __construct(private ServiceResponse $serviceResponse)
    {

    }

    /**
     * @return ServiceResponse
     */
    public function fetchRequests(): ServiceResponse
    {
        $userRequests = MakerChecker::where(['checkable_type' => User::class, 'status' => 'pending'])
            ->get();
        return $this->serviceResponse->setMessage('User requests fetched successfully')->setData(['userRequests' => $userRequests])
            ->setIsSuccess(true);
    }

    /**
     * @param CreateUserResouceRequest $request
     * @param Admin $admin
     * @return ServiceResponse
     */
    public function createRequest(CreateUserResouceRequest $request, Admin $admin): ServiceResponse
    {
        if (in_array($request->request_type, ['delete-user', 'update-user'])) {
            $userExist = User::where(['id' => $request->user_id])->exists();
            if (!$userExist) {
                return $this->serviceResponse->setMessage('Invalid operation')
                    ->setIsSuccess(false);
            }
        }
        $makerChecker = MakerChecker::create(['request_type' => $request->request_type, 'request_data' => json_encode($request->request_data ?? []),
            'status' => 'pending', 'maker_id' => $admin->id, 'checkable_type' => User::class,'checkable_id'=>$request->user_id]);
        $admins = Admin::where('id', '!=', $admin->id)->get();
        $this->bulkNotification(new UserCreateRequestNotification($makerChecker), $admins);
        return $this->serviceResponse->setMessage('User request was submitted successfully')
            ->setData(['created'=>true])
            ->setIsSuccess(true);
    }


    /**
     * @param AcceptUserRequest $request
     * @param Admin $admin
     * @return ServiceResponse
     * @throws \Exception
     */
    public function acceptRequest(AcceptUserRequest $request, Admin $admin): ServiceResponse
    {
        $makerChecker = MakerChecker::where(['id' => $request->maker_checker_id, 'status' => 'pending'])
            ->where('maker_id','!=', $admin->id)->first();
        if (empty($makerChecker)) {
            return $this->serviceResponse->setMessage('Invalid operation')
                ->setIsSuccess(false);
        }
        $this->treatRequest($makerChecker);
        $makerChecker->update(['status' => 'accepted', 'checker_id' => $admin->id]);
        return $this->serviceResponse->setMessage('Request was accepted successfully')
            ->setData([])
            ->setIsSuccess(true);
    }

    /**
     * @param RejectUserRequest $request
     * @param Admin $admin
     * @return ServiceResponse
     */
    public function rejectRequest(RejectUserRequest $request, Admin $admin): ServiceResponse
    {
        $makerChecker = MakerChecker::where(['id' => $request->maker_checker_id, 'status' => 'pending'])
            ->where('maker_id','!=', $admin->id)->first();
        if (empty($makerChecker)) {
            return $this->serviceResponse->setMessage('Invalid operation')
                ->setIsSuccess(false);
        }
        $makerChecker->update(['status' => 'rejected', 'checker_id' => $admin->id]);
        return $this->serviceResponse->setMessage('Request was rejected successfully')
            ->setData([])
            ->setIsSuccess(true);
    }


    /**
     * @throws \Exception
     */
    public function treatRequest($makerChecker): void
    {
        $requestData = $makerChecker->request_data;
        switch ($makerChecker->request_type) {
            case 'create-user':
                $this->createUser($requestData);
                break;
            case 'update-user':
                $this->updateUser($makerChecker->checkable_id, $requestData);
                break;
            case 'delete-user':
                $this->deleteUser($makerChecker->checkable_id);
                break;
            default:
                throw new \Exception('Invalid request type');
                break;
        }
    }

    private function createUser(array $requestData): void
    {
        User::create([
            'email' => $requestData['email'],
            'first_name' => $requestData['first_name'],
            'last_name' => $requestData['last_name'],
            'password' => Hash::make(Str::random(8))
        ]);
    }

    private function updateUser(int $userId, array $requestData): void
    {
        $user = User::findOrFail($userId);
        $user->update([
            'email' => $requestData['email'],
            'first_name' => $requestData['first_name'],
            'last_name' => $requestData['last_name']
        ]);
    }

    private function deleteUser(int $userId): void
    {
        $user = User::findOrFail($userId);
        $user->delete();
    }

}
