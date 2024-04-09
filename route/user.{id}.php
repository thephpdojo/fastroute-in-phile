<?php
response()->json([
    'user_id' => $request->attributes->get('id')
]);
