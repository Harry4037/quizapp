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


// Home > [Subject]
Breadcrumbs::for('admin.subject.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push("Subject", route('admin.subject.index'));
});
Breadcrumbs::for('admin.subject.add', function ($trail) {
    $trail->parent('admin.subject.index');
    $trail->push("Add", route('admin.subject.add'));
});
Breadcrumbs::for('admin.subject.edit', function ($trail, $subject) {
    $trail->parent('admin.subject.index');
    $trail->push("Edit", route('admin.subject.edit', $subject));
});

// Home > [Exam]
Breadcrumbs::for('admin.exam.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push("Exam", route('admin.exam.index'));
});
Breadcrumbs::for('admin.exam.add', function ($trail) {
    $trail->parent('admin.subject.index');
    $trail->push("Add", route('admin.subject.add'));
});
Breadcrumbs::for('admin.exam.edit', function ($trail, $exam) {
    $trail->parent('admin.exam.index');
    $trail->push("Edit", route('admin.exam.edit', $exam));
});
