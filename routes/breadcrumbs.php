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

// Home > [User]
Breadcrumbs::for('admin.user.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push("User", route('admin.user.index'));
});
Breadcrumbs::for('admin.user.add', function ($trail) {
    $trail->parent('admin.user.index');
    $trail->push("Add", route('admin.user.add'));
});
Breadcrumbs::for('admin.user.edit', function ($trail, $user) {
    $trail->parent('admin.user.index');
    $trail->push("Edit", route('admin.user.edit', $user));
});

