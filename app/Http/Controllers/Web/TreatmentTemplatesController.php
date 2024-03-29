<?php


namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Models\Business\TemplateOption;
use App\Models\Business\TreatmentOption;
use App\Models\Business\TreatmentTemplate;
use App\Models\Business\TreatmentType;
use App\Services\v1\TreatmentTemplatesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TreatmentTemplatesController extends Controller
{
    private $treatmentTemplateService;

    public function __construct(TreatmentTemplatesService $treatmentTemplateService){
        $this->treatmentTemplateService = $treatmentTemplateService;
    }

    public function index()
    {
        if(request()->ajax())
        {
            return datatables()->of(TreatmentTemplate::query())
                ->addColumn('edit', function($data){
                    return '<button class="btn btn-primary btn-sm btn-block " data-id="'.$data->id.'" onclick="editTemplate(event.target)" ><i class="fas fa-edit" data-id="'.$data->id.'"></i> Изменить</button>';
                })
                ->addColumn('more', function ($data){
                    return '<a class="text-decoration-none" href="'.route('treatment.templates.show', $data->id).'"><button class="btn btn-primary btn-sm btn-block ">Подробнее</button></a>';
                })
                ->rawColumns(['more','edit'])
                ->make(true);
        }
        return view('web.treatment.templates.index');
    }

    public function store(Request $request){
        $error = Validator::make($request->all(), array(
            'name'=> 'required',
            'code' => 'required|numeric|unique:treatment_templates,code,'. $request->id,
        ));

        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $template = $this->treatmentTemplateService->store($request);

        return response()->json(['code'=>200, 'message'=>'Template saved successfully','data' => $template], 200);
    }

    public function edit($id){
        return response()->json(TreatmentTemplate::findOrFail($id));
    }

    public function show($id){
        $template = TreatmentTemplate::findOrFail($id);
        if(request()->ajax())
        {
            return datatables()->of($template->types()->latest()->get())
                ->addColumn('edit', function($data){
                    return '<button class="btn btn-primary btn-sm btn-block " data-id="'.$data->id.'" onclick="editType(event.target)" ><i class="fas fa-edit" data-id="'.$data->id.'"></i> Изменить</button>';
                })
                ->addColumn('more', function ($data){
                    return '<a class="text-decoration-none" href="'.route('treatment.types.show', $data->id).'"><button class="btn btn-primary btn-sm btn-block ">Подробнее</button></a>';
                })
                ->rawColumns(['more','edit'])
                ->make(true);
        }
        return view('web.treatment.templates.show', compact('template'));
    }

    public function storeType(Request $request){
        $error = Validator::make($request->all(), array(
            'name'=> 'required',
            'template_id'=> 'required',
        ));

        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $type = $this->treatmentTemplateService->storeType($request);

        return response()->json(['code'=>200, 'message'=>'Template type saved successfully','data' => $type], 200);
    }

    public function editType($id){
        return response()->json(TreatmentType::findOrFail($id));
    }

    public function showType($id){
        $type = TreatmentType::with('templates')->findOrFail($id);
        if(request()->ajax())
        {
            return datatables()->of($type->options()->latest()->get())
                ->addColumn('edit', function($data){
                    return '<button class="btn btn-primary btn-sm btn-block " data-id="'.$data->id.'" onclick="editType(event.target)" ><i class="fas fa-edit" data-id="'.$data->id.'"></i> Изменить</button>';
                })
                ->addColumn('more', function ($data){
                    return '<a class="text-decoration-none" href="'.route('treatment.types.show', $data->id).'"><button class="btn btn-primary btn-sm btn-block ">Подробнее</button></a>';
                })
                ->rawColumns(['more','edit'])
                ->make(true);
        }
        return view('web.treatment.types.show', compact('type'));
    }

    public function storeOption(Request $request){
        $error = Validator::make($request->all(), array(
            'value'=> 'required',
            'type_id'=> 'required',
            'template_id' => 'required',
        ));

        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $option = $this->treatmentTemplateService->storeOption($request);

        return response()->json(['code'=>200, 'message'=>'Template option saved successfully','data' => $option], 200);
    }

    public function editOption($id){
        return response()->json(TreatmentOption::findOrFail($id));
    }

}
