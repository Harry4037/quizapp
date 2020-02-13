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

// Home > [Creator]
Breadcrumbs::for('admin.creator.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push("Creator", route('admin.creator.index'));
});
Breadcrumbs::for('admin.creator.add', function ($trail) {
    $trail->parent('admin.creator.index');
    $trail->push("Add", route('admin.creator.add'));
});
Breadcrumbs::for('admin.creator.edit', function ($trail, $user) {
    $trail->parent('admin.creator.index');
    $trail->push("Edit", route('admin.creator.edit', $user));
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
    $trail->parent('admin.exam.index');
    $trail->push("Add", route('admin.exam.add'));
});
Breadcrumbs::for('admin.exam.edit', function ($trail, $exam) {
    $trail->parent('admin.exam.index');
    $trail->push("Edit", route('admin.exam.edit', $exam));
});

// Home > [Question]
Breadcrumbs::for('admin.question.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push("Question", route('admin.question.index'));
});
Breadcrumbs::for('admin.question.add', function ($trail) {
    $trail->parent('admin.question.index');
    $trail->push("Add", route('admin.question.add'));
});
Breadcrumbs::for('admin.question.edit', function ($trail, $exam) {
    $trail->parent('admin.question.index');
    $trail->push("Edit", route('admin.question.edit', $exam));
});

// Home > [TestSeries]
Breadcrumbs::for('admin.testseries.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push("Testseries", route('admin.testseries.index'));
});
Breadcrumbs::for('admin.testseries.add', function ($trail) {
    $trail->parent('admin.testseries.index');
    $trail->push("Add", route('admin.testseries.add'));
});
Breadcrumbs::for('admin.testseries.edit', function ($trail, $testseries) {
    $trail->parent('admin.testseries.index');
    $trail->push("Edit", route('admin.testseries.edit', $testseries));
});

// Home > [Leadership]
Breadcrumbs::for('admin.leadership.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push("Leadership", route('admin.leadership.index'));
});

// Home > [Cms]
Breadcrumbs::for('admin.cms.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push("Cms", route('admin.cms.index'));
});
Breadcrumbs::for('admin.cms.edit', function ($trail, $cms) {
    $trail->parent('admin.cms.index');
    $trail->push("Edit", route('admin.cms.edit', $cms));
});

// Home > [Feed]
Breadcrumbs::for('admin.feedback.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push("feedback", route('admin.feedback.index'));
});

