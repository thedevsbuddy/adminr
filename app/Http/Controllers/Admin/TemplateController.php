<?php

namespace App\Http\Controllers\Admin;

use Devsbuddy\AdminrCore\Http\Controllers\AdminrController;
use Devsbuddy\AdminrCore\Models\MailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TemplateController extends AdminrController
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
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

    /**
     * Show the form for creating a new resource.
     *
     * @return mixed
     */
    public function create()
    {
        try{
            return view('adminr.templates.create');
        } catch (\Exception $e){
            return $this->backError('Error: ' . $e->getMessage());
        } catch (\Error $e){
            return $this->backError('Error: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function store(Request $request)
    {

        $request->validate([
            'subject' => ['required', 'unique:mail_templates'],
            'code' => ['required', 'unique:mail_templates'],
            'content' => ['required'],
        ]);

        try{
            MailTemplate::create([
                'subject' => trim($request->get('subject')),
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return mixed
     */
    public function edit($id)
    {
        try{
            $template = MailTemplate::find($id);
            return view('adminr.templates.edit', compact('template'));
        } catch (\Exception $e){
            return $this->backError('Error: ' . $e->getMessage());
        } catch (\Error $e){
            return $this->backError('Error: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'subject' => ['required'],
            'code' => ['required'],
            'content' => ['required'],
        ]);

        try{
            MailTemplate::where('id', $id)->update([
                'subject' => trim($request->get('subject')),
                'code' => Str::kebab(trim($request->get('code'))),
                'content' => $request->get('content'),
            ]);
            return $this->backSuccess('Mail template created successfully!');
        } catch (\Exception $e){
            return $this->backError('Error: ' . $e->getMessage());
        } catch (\Error $e){
            return $this->backError('Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return mixed
     */
    public function destroy($id)
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
