In laravel 8/fortify app I use spatie/laravel-permission and in control I have several actions(including ajax requests) with same rules :




public function index()
{
    if ( !isUserLogged() or ! Auth::user()->hasAnyPermission([PERMISSION_ADMIN, PERMISSION_USER_WITH_ACCESS])) {
        Auth::logout();
        return redirect('/login')
        ->with('status', 'You have no permission to enter Items.index methods');
    }
    ...
    return view('admin.item.index', [
        ...
    ]);

}

It works, but I wonder if there is a way to short it someway?

Think about using construct, like:
public function __construct()
{
    parent::__construct();
    if ( !isUserLogged() or ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN, PERMISSION_APP_MANAGER])) {
         Auth::logout();
         return redirect('/login')
             ->with('status', 'You have no permission to enter Items pages');
    }
}

But not sure if that is good way ? As far as I remember in 5.x such way did not work...
Which way can be used now?


Thanks in advance!
