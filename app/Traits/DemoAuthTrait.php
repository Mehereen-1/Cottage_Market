<?php

namespace App\Traits;

trait DemoAuthTrait
{
    protected function getDemoUser()
    {
        return session('demo_user');
    }

    protected function getDemoUserId()
    {
        $user = $this->getDemoUser();
        return $user ? $user['id'] : null;
    }

    protected function getDemoUserRole()
    {
        $user = $this->getDemoUser();
        return $user ? $user['role'] : null;
    }

    protected function requireDemoUser()
    {
        $user = $this->getDemoUser();
        if (!$user) {
            abort(403, 'Please log in to access this page.');
        }
        return $user;
    }

    protected function requireRole($role)
    {
        $user = $this->requireDemoUser();
        if ($user['role'] !== $role) {
            abort(403, 'Access denied. Required role: ' . $role);
        }
        return $user;
    }
}
