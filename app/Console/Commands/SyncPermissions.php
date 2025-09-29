<?php

namespace App\Console\Commands;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class SyncPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all permission to database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $routes = Route::getRoutes();
        
        $modules = [];
        $permissions = [];

        // Group routes by module
        foreach ($routes as $route) {
       
            if (in_array('web', $route->middleware())) {
                
                $routeName = $route->getName();

                if ($routeName && isset($route->getAction()['module'])) {
                    $moduleName = $route->getAction()['module'];

                    if (!isset($modules[$moduleName])) {
                        $modules[$moduleName] = ['name' => $moduleName];
                    }

                    $permissions[$moduleName][] = $routeName;
                }
            }
        }

        $insertCount = 0;
        $updateCount = 0;
        $deleteCount = 0;
        $untouched = 0;

        foreach ($modules as $moduleData) {
            $module = Module::firstOrCreate($moduleData);
            $moduleId = $module->id;

            $currentPermissionSlugs = [];

            foreach ($permissions[$moduleData['name']] as $permission) {
                $formattedPermissionName = $this->formatPermissionName($permission);
                $slug = $permission;
                $currentPermissionSlugs[] = $slug;

                $existingPermission = Permission::where('slug', $slug)
                    ->where('module_id', $moduleId)
                    ->first();

                    // dd($moduleId);
                if (!$existingPermission) {
                    Permission::create([
                        'module_id' => $moduleId,
                        'name' => $formattedPermissionName,
                        'slug' => $slug,
                    ]);
                    $insertCount++;
                } elseif ($existingPermission->name !== $formattedPermissionName) {
                    $existingPermission->update([
                        'name' => $formattedPermissionName,
                    ]);
                    $updateCount++;
                }else
                {
                    $untouched++;

                }
            }

            // Optional: delete old permissions not present in current routes
            $deleted = Permission::where('module_id', $moduleId)
                ->whereNotIn('slug', $currentPermissionSlugs)
                ->delete();

            $deleteCount += $deleted;
        }

        $this->info("✅ Permissions synced successfully!");
        $this->line("🔹 Inserted: {$insertCount}");
        $this->line("🔹 Updated: {$updateCount}");
        $this->line("🔹 Deleted: {$deleteCount}");
        $this->line("🔹 Untouched: {$untouched}");
    }

    protected function formatPermissionName($routeName)
    {
        $segments = explode('.', $routeName);
        return implode(' ', array_map('ucwords', $segments));
    }

} 
