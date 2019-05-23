<?php

namespace App\Admin\Controllers;

use App\Model\RegpassModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class RegpassController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new RegpassModel);

        $grid->id('Id');
        $grid->name('Name');
        $grid->shui('Shui');
        $grid->dui('Dui');
        $grid->img('Img')->display(function($res){
            return "<img src='http://vm.one.api.com/$res' width='100px'>";
        });
        $grid->APPID('APPID');
        $grid->key('Key');
       // $grid->status('Status');


//        //设置text、color、和存储值
//                       $states = [
//                           'on'  => ['value' => 0, 'text' => '通过', 'color' => 'primary'],
//                           'off' => ['value' => 1, 'text' => '未审核', 'color' => 'default'],
//                       ];
//        $grid->status()->switch();
        $grid->status()->display(function ($released) {
            return $released ? '已审核' : '未审核';
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(RegpassModel::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->shui('Shui');
        $show->dui('Dui');
        $show->img('Img');
        $show->APPID('APPID');
        $show->key('Key');
        $show->status('Status');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new RegpassModel);

        $form->text('name', 'Name');
        $form->text('shui', 'Shui');
        $form->text('dui', 'Dui');
        $form->image('img', 'Img');
        $form->number('APPID', 'APPID');
        $form->number('key', 'Key');
        $form->text('status', 'Status');

        return $form;
    }
}
