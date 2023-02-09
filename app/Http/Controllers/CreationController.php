<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreationRequest;
use App\Http\Requests\LikeRequest;
use App\Models\Creation;
use App\Models\Likes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Decimal;

class CreationController extends Controller
{

    public function index()
    {
        return Creation::all();
    }


    public function create()
    {
    }


    public function store(CreationRequest $request)
    {
        $creation = Creation::create($request->all());
        $hola = User::find($creation->user_id);
        $creation->name_user = $hola->name;
        $creation->update($request->all());
        return response()->json([
            'success'   => true,
            'message'   => 'Creación éxitosa',
            'data'      => $creation
        ]);
    }

    public function show(Request $request)
    {
        $creation = Creation::where('id', $request->id)->first();
        if ($creation) {
            $hola = User::find($creation->user_id);
            $name = $hola->name;
            return response()->json([
                'success'   => true,
                'name'      =>  $name
            ]);
        }
    }


    public function edit($id)
    {
        //
    }

    public function Looks(Request $request)
    {
        if ($request->has('tridy_id')) {
            $creation = Creation::find($request->tridy_id);
            if ($creation) {
                $creation->looks =  $creation->looks + 1;
            }
            $creation->update($request->all());
            return response()->json([
                'success'   => true,
            ]);
        }
        return response()->json([
            'success'   => false,
        ]);
    }
    public function updateTridy(Request $request)
    {
        if ($request->has('tridy_id')) {
            $creation = Creation::find($request->tridy_id);
            $creation->update($request->all());
            return response()->json([
                'success'   => true,
                'message'   => 'Creación éxitosa',
                'data'      => $creation
            ]);
        }
        return response()->json([
            'success'   => false,
        ]);
    }






    public function update(LikeRequest $request)
    {
        $like = Likes::where('user_id', $request->user_id)->where('tridy_id', $request->tridy_id)->first();
        if ($like) {
            if ($request->has('tridy_id')) {
                $creation = Creation::find($request->tridy_id);
                if ($creation) {
                    if ($creation->likes > 0) {
                        $creation->likes =  $creation->likes - 1;
                    }
                    $like->delete();
                    $creation->update($request->all());
                    return response()->json([
                        'success'   => true,
                    ]);
                }
            }
        } else {
            if ($request->has('tridy_id')) {
                $creation = Creation::find($request->tridy_id);
                if ($creation) {
                    $creation->likes =  $creation->likes + 1;
                    Likes::create($request->all());
                    $creation->update($request->all());
                    return response()->json([
                        'success'   => true,
                    ]);
                }
            }
        }
        return response()->json([
            'success'   => false,
        ]);
    }


    public function UbicationMe(Request $request)
    {
        $creation = DB::SELECT('select * from (SELECT *, ( 6371 * acos( cos( radians(' . $request->lat . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $request->lon . ') ) + sin( radians(' . $request->lat . ') ) * sin( radians( latitude ) ) ) ) AS distance FROM creations) al where distance < 15 ORDER BY distance');

        if ($creation) {
            return response()->json([
                'success'   => true,
                'message'   => 'Buscar',
                'data'      => $creation
            ]);
        }
        return response()->json([
            'success'   => false,
            'message'   => 'No hay nada cerca',
            'data'      => null
        ]);
    }

    public function MeCreations(Request $request)
    {
        $creation = DB::SELECT('(SELECT * FROM creations al where user_id = ' . $request->id_user . ')');

        if ($creation) {
            return response()->json([
                'success'   => true,
                'message'   => 'Si hay Tridys',
                'data'      => $creation
            ]);
        }
        return response()->json([
            'success'   => false,
            'message'   => 'No hay Tridys',
            'data'      => null
        ]);
    }


    public function CreationsView(Request $request)
    {

        $user = User::where('email',$request['email'])->first();
        return response()->json([
            'success'   => true,
            'message'   => 'Si hay Tridys',
            'data'      => $user
        ]);
    }


    public function destroy(Request $request)
    {
        if ($request->has('id')) {
            $creation = Creation::find($request->id);
            if ($creation) {
                $creation->delete();
                return response()->json([
                    'success'   => true,
                    'message'   => 'Se eliminó',
                    'data'      => null
                ]);
            }
        }
        return response()->json([
            'success'   => false,
            'message'   => 'No llegó o no éxiste el identificador',
            'data'      => null
        ]);
    }
}
