<?php
namespace App\Controllers;

use \TypeRocket\Controllers\Controller;

class FormController extends Controller
{

    /**
     * The index page for admin
     *
     * @return mixed
     */
    public function index()
    {
        // TODO: Implement index() method.
        return tr_view('form.index');
    }

    /**
     * The add page for admin
     *
     * @return mixed
     */
    public function add()
    {
        // TODO: Implement add() method.
    }

    /**
     * Create item
     *
     * AJAX requests and normal requests can be made to this action
     *
     * @return mixed
     */
    public function create()
    {
        // TODO: Implement create() method.
    }

    /**
     * The edit page for admin
     *
     * @param $id
     *
     * @return mixed
     */
    public function edit($id)
    {
        // TODO: Implement edit() method.
    }

    /**
     * Update item
     *
     * AJAX requests and normal requests can be made to this action
     *
     * @param $id
     *
     * @return mixed
     */
    public function update($id)
    {
        // TODO: Implement update() method.
    }

    /**
     * The show page for admin
     *
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        // TODO: Implement show() method.
    }

    /**
     * The delete page for admin
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * Destroy item
     *
     * AJAX requests and normal requests can be made to this action
     *
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }

    public function contact(){
        return 'fine';
    }
}