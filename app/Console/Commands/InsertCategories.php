<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class InsertCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:Categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inserts category names';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->info('Insertion started');

        foreach(config('app.category_names') as $name)
        {
            $record = Category::updateOrCreate(
                [
                    'name' => $name,
                ]);
        }

        $this->info('Insertion completed');
    }
}
