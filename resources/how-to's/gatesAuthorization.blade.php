@can('AuthorizeAction',['ADD_UPDATE_CATEGORY'])


@endcan


if (Gate::allows('AuthorizeAction', ['ADD_UPDATE_CATEGORY'])) {
    // User is authorized, perform the action
} else {
    // User is not authorized, handle accordingly (e.g., show error, redirect)
}
