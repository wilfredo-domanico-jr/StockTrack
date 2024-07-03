$supplier_model = Supplier::findOrFail($request->supplier_id);
        // foreach ($request->except('_token') as $data => $value) {
        //     $valids[$data] = "required";
        // }
        // $valids['type'] = 'required|not_in:0';
        // $valids['status'] = 'required|not_in:0';
        // $request->validate($valids);

        $rules = [
            'type' => 'required|not_in:0',
            'name' => 'required|not_in:0',
            'effective_date' => 'required|not_in:0',
            'end_date' => 'required|not_in:0',
            'status' => 'required|not_in:0',
            'status' => 'required|not_in:0',
            'renewal' => 'required|not_in:0',

        ];



        $request->validate($rules);

