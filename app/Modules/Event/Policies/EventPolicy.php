<?php

namespace App\Modules\Event\Policies;

use App\Modules\Admin\Models\User\Admin;
use App\Modules\Event\Models\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param Admin $user
     * @param Event $item
     *
     * @return boolean
     */
    public function update(Admin $user, Event $item)
    {
        if (auth()->user()->can(getPermissionKey('event', 'moderator', false))) {
            return $item->moderator_id === $user->id;
        }

        return auth()->user()->can(getPermissionKey('event', 'full_manage', false));
    }

    /**
     * @param Admin $user
     * @param Event $item
     *
     * @return boolean
     */
    public function statusUpdate(Admin $user, Event $item)
    {
        if (auth()->user()->can(getPermissionKey('event', 'moderator', false))) {
            return $item->moderator_id === $user->id;
        }

        return auth()->user()->can(getPermissionKey('event', 'full_manage', false));
    }

    /**
     * @param Admin $user
     * @param Event $item
     *
     * @return boolean
     */
    public function show(Admin $user, Event $item)
    {
        if (auth()->user()->can(getPermissionKey('event', 'moderator', false))) {
            return $item->moderator_id === $user->id;
        }

        return auth()->user()->can(getPermissionKey('event', 'show', false));
    }

    /**
     * @param Admin $user
     * @param Event $item
     *
     * @return boolean
     */
    public function showQuestions(Admin $user, Event $item)
    {
        if (auth()->user()->can(getPermissionKey('event', 'moderator', false))) {
            return $item->moderator_id === $user->id;
        }

        return auth()->user()->can(getPermissionKey('event', 'show_questions', false));
    }

}
