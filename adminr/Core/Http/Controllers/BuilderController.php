<?php

namespace Adminr\Core\Http\Controllers;

use Adminr\Core\Database;
use Adminr\Core\Services\{AdminrApiResourcesBuilderService,
    AdminrBuilderService,
    AdminrControllersBuilderService,
    AdminrMiddlewareBuilderService,
    AdminrMigrationBuilderService,
    AdminrModelBuilderService,
    AdminrRequestsBuilderService,
    AdminrResourceInfoBuilderService,
    AdminrRoutesBuilderService,
    AdminrViewsBuilderService};
use App\Http\Controllers\Controller;
use Adminr\Core\Models\{AdminrResource};
use Adminr\Core\Traits\HasStubs;
use Illuminate\Contracts\View\View;
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\Support\Facades\{File, Artisan};
use Illuminate\Support\Str;

class BuilderController extends Controller
{
    use HasStubs;

    public function index(): View|RedirectResponse
    {
        try {
            $dataTypes = collect(Database::dataTypes())->sort()->toArray();
            return view('adminr::builder.create', compact('dataTypes'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function build(Request $request): JsonResponse
    {
//        if ($this->resourceExists($request) && $request->get('override_resource') != 'true') {
//            return response()->json(['status' => 'error', 'message' => 'Resource already exist!'], 200);
//        }

        try {
            /// Create an instance of [AdminrBuilderService]
            $builderService = new AdminrBuilderService($request);

            /// Prepare Controllers
            $controllerService = new AdminrControllersBuilderService($builderService);
            $controllerService->prepare();

            /// Prepare ApiResource
            $requestService = new AdminrApiResourcesBuilderService($builderService);
            $requestService->prepare();

            /// Prepare Requests
            $apiResourceService = new AdminrRequestsBuilderService($builderService);
            $apiResourceService->prepare();

            /// Prepare Models
            $modelService = new AdminrModelBuilderService($builderService);
            $modelService->prepare();

            /// Prepare Migrations
            $migrationService = new AdminrMigrationBuilderService($builderService);
            $migrationService->prepare();

            /// Prepare Views
            $viewsService = new AdminrViewsBuilderService($builderService);
            $viewsService->prepare();

            /// Prepare Routes
            $routesService = new AdminrRoutesBuilderService($builderService);
            $routesService->prepare();

            /// Prepare Middlewares
            $middlewareService = new AdminrMiddlewareBuilderService($builderService);
            $middlewareService->prepare();

            /// Prepare Resource Info File
            $resourceInfoService = new AdminrResourceInfoBuilderService($builderService);
            $resourceInfoService->prepare();

            /// ================================
            /// Finalize and create resource
            $builderService->publish();

//            Artisan::call('migrate');

            return response()->json(['status' => 'success', 'message' => 'Resource generated Successfully!', 'entities' => 'ssd'], 200);
        } catch (\Exception|\Error $e) {
            info($e->getMessage());
            $this->rollbackAll();
            return response()->json(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()], 200);
        }
    }


    private function resourceExists(Request $request): bool
    {
        $resource = AdminrResource::where('name', Str::snake($request->get('model')))->where('model', $request->get('model'))->first();
        $model = File::exists(app_path() . "/Models/" . Str::title($request->get('model')) . ".php");
        if (!is_null($resource)) {
            return true;
        }
        if ($model) {
            return true;
        }
        return false;
    }


    private function rollbackAll()
    {
    }
}
