<?php
response()->json([
    'user_id' => $request->route('id'),
    'request_method' => $request->method(),
]);
