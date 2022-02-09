## Installation

Run the following commands to set up the application, given that php and composer are available:
1. `git clone` https://github.com/imabhi01/assignment.git
1. `cd assignment`
1. `composer install`
1. `cp .env.example .env`

## Running Tests
1. `vendor/bin/phpunit`
1. For code coverage:  `vendor/bin/phpunit --coverage-text`
1. Additionally a report can also be generated using the command `vendor/bin/phpunit --coverage-html=reports`

## How to use the project
The tests provide a basic overview of the application. Some steps can be done to see the application in action, which are.

1. The data for comments and lessons can be seeded via Tinker and achievements and badges can be seen.
    1. `php artisan tinker`
    2. ```php
       $user = User::factory()->create();

        Comment::factory()->count(3)->create([
           'user_id' => $user->id,
       ]);

        $user->lessons()->attach(Lesson::factory()->count(5)->create(),['watched' => true]);
        
        php artisan sync-achievements comment_written
        php artisan sync-achievements lesson_watched 
       
       ```
    3. Which results in the  output for url `/users/1/achievements`
        ```json
        {
            "unlocked_achievements": [
                "First Comment Written",
                "3 Comments Written",
                "First Lesson Watched",
                "5 Lessons Watched"
            ],
            "next_available_achievements": [
                "10 Lessons Watched",
                "5 Comments Written"
            ],
            "current_badge": "Intermediate",
            "next_badge": "Advanced",
            "remaining_to_unlock_next_badge": 4
        } 
        ```
