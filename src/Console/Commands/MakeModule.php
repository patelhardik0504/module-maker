<?php

namespace Hardudev\ModuleMaker\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new Laravel module with Model, Migration, Controller, and Views';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Get the module name from the argument
        $name = $this->argument('name');

        // Generate the module files
        $this->generateModel($name);
        $this->generateMigration($name);
        $this->generateController($name);
        $this->generateViews($name);

        $this->info("Module '$name' generated successfully!");
    }

    /**
     * Generate the Model file.
     *
     * @param string $name
     * @return void
     */
    private function generateModel($name)
    {
        $modelTemplate = "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Eloquent\Factories\HasFactory;\nuse Illuminate\Database\Eloquent\Model;\n\nclass $name extends Model\n{\n    use HasFactory;\n}\n";

        File::put(app_path("Models/{$name}.php"), $modelTemplate);
        $this->info("Model $name generated.");
    }

    /**
     * Generate the Migration file.
     *
     * @param string $name
     * @return void
     */
    private function generateMigration($name)
    {
        $migrationName = "create_{$name}_table";
        $migrationTemplate = "<?php\n\nuse Illuminate\Database\Migrations\Migration;\nuse Illuminate\Database\Schema\Blueprint;\nuse Illuminate\Support\Facades\Schema;\n\nclass $migrationName extends Migration\n{\n    public function up()\n    {\n        Schema::create('$name', function (Blueprint \$table) {\n            \$table->id();\n            \$table->timestamps();\n        });\n    }\n\n    public function down()\n    {\n        Schema::dropIfExists('$name');\n    }\n}\n";

        // Generate migration file in database/migrations directory
        $migrationPath = database_path("migrations/" . date('Y_m_d_His') . "_{$migrationName}.php");
        File::put($migrationPath, $migrationTemplate);
        $this->info("Migration for $name created.");
    }

    /**
     * Generate the Controller file.
     *
     * @param string $name
     * @return void
     */
    private function generateController($name)
    {
        $controllerTemplate = "<?php\n\nnamespace App\Http\Controllers;\n\nuse App\Models\\$name;\nuse Illuminate\Http\Request;\n\nclass {$name}Controller extends Controller\n{\n    public function index()\n    {\n        \$items = $name::all();\n        return view('{$name}.index', compact('items'));\n    }\n\n    public function create()\n    {\n        return view('{$name}.create');\n    }\n\n    public function store(Request \$request)\n    {\n        $name::create(\$request->all());\n        return redirect()->route('{$name}.index');\n    }\n\n    public function edit($id)\n    {\n        \$item = $name::find(\$id);\n        return view('{$name}.edit', compact('item'));\n    }\n\n    public function update(Request \$request, $id)\n    {\n        \$item = $name::find(\$id);\n        \$item->update(\$request->all());\n        return redirect()->route('{$name}.index');\n    }\n\n    public function destroy($id)\n    {\n        \$item = $name::find(\$id);\n        \$item->delete();\n        return redirect()->route('{$name}.index');\n    }\n}\n";

        // Generate controller file in app/Http/Controllers directory
        File::put(app_path("Http/Controllers/{$name}Controller.php"), $controllerTemplate);
        $this->info("Controller {$name}Controller generated.");
    }

    /**
     * Generate Blade views (index, create, edit) for the module.
     *
     * @param string $name
     * @return void
     */
    private function generateViews($name)
    {
        // Create Blade view files for index, create, edit
        $views = ['index', 'create', 'edit', 'view'];
        foreach ($views as $view) {
            $viewTemplate = "<!-- View for $view page of $name module -->\n\n<h1>$view</h1>";

            // Save the view files to resources/views directory
            File::put(resource_path("views/{$name}/{$view}.blade.php"), $viewTemplate);
            $this->info("Blade view for $view generated.");
        }
    }
}
