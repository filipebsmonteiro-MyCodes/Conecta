<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MembroPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the membro.
     *
     * @param  \App\User  $user
     * @param  \App\Membro  $membro
     * @return mixed
     */
    public function view(User $user, $idIgreja)
    {
    	return $user->Igrejas_idIgrejas	==	$idIgreja;
    }

    /**
     * Determine whether the user can create membros.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the membro.
     *
     * @param  \App\User  $user
     * @param  \App\Membro  $membro
     * @return mixed
     */
    public function update(User $user)
    {
        //
    }

    /**
     * Determine whether the user can delete the membro.
     *
     * @param  \App\User  $user
     * @param  \App\Membro  $membro
     * @return mixed
     */
    public function delete(User $user)
    {
        //
    }
}
