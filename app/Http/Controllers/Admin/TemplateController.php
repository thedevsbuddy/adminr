<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MailTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TemplateController extends Controller
{
    public function index(): View|RedirectResponse
    {
        try{
            $templates = MailTemplate::paginate(10);
            return view('adminr.templates.index', compact('templates'));
        } catch (\Exception $e){
            return $this->backError('Error: ' . $e->getMessage());
        } catch (\Error $e){
            return $this->backError('Error: ' . $e->getMessage());
        }
    }

    public function create(): View|RedirectResponse
    {
        try{
            return view('adminr.templates.create');
        } catch (\Exception $e){
            return $this->backError('Error: ' . $e->getMessage());
        } catch (\Error $e){
            return $this->backError('Error: ' . $e->getMessage());
        }
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {

        $request->validate([
            'subject' => ['required', 'unique:mail_templates'],
            'code' => ['required', 'unique:mail_templates'],
            'content' => ['required'],
        ]);

        try{
            MailTemplate::create([
                'subject' => trim($request->get('subject')),
                'purpose' => trim($request->get('purpose')),
                'code' => Str::kebab(trim($request->get('code'))),
                'content' => $request->get('content'),
            ]);

            if ($request->ajax()){
                return $this->successMessage("Mail template created successfully!");
            }

            return $this->backSuccess('Mail template created successfully!');
        } catch (\Exception $e){
            return $this->backError('Error: ' . $e->getMessage());
        } catch (\Error $e){
            return $this->backError('Error: ' . $e->getMessage());
        }
    }


    public function edit($id): View|RedirectResponse
    {
        try{
            $template = MailTemplate::where('id', decrypt($id))->first();
            return view('adminr.templates.edit', compact('template'));
        } catch (\Exception $e){
            return $this->backError('Error: ' . $e->getMessage());
        } catch (\Error $e){
            return $this->backError('Error: ' . $e->getMessage());
        }
    }


    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'subject' => ['required'],
            'content' => ['required'],
        ]);

        try{
            MailTemplate::where('id', $id)->update([
                'subject' => trim($request->get('subject')),
                'purpose' => trim($request->get('purpose')),
                'content' => $request->get('content'),
            ]);
            return $this->backSuccess('Mail template updated successfully!');
        } catch (\Exception $e){
            return $this->backError('Error: ' . $e->getMessage());
        } catch (\Error $e){
            return $this->backError('Error: ' . $e->getMessage());
        }
    }

    public function destroy($id): RedirectResponse
    {
        try{
            MailTemplate::where('id', $id)->delete();
            return $this->backSuccess('Template deleted successfully!');
        } catch (\Exception $e){
            return back()->with('error', 'Error: ' . $e->getMessage());
        } catch (\Error $e){
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
