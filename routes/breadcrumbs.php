<?php

//////////////// Admin Breadcrumbs ///////////////////
// Dashboard
Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard'));
});
Breadcrumbs::for('admin.profile', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push("Profile", route('admin.profile'));
});


