<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Reserve;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function atualizar_campos($request) 
    {
        $this->name   = $request->name;
        $this->email  = $request->email;

//Verifica se atualizou a senha, caso contrário não atualiza como null ...
        if($request->password && $request->password != '')
            $this->password = bcrypt($request->password);

        $newNameFile = '';

        if($request->hasFile('image') && $request->file('image')->isValid()) {
            
            $nameFile       = uniqid(date('HisYmd'));
            $extension      = $request->image->extension();
            $newNameFile    = "{$nameFile}.{$extension}";

            if(!$request->image->storeAs('users', $newNameFile))
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer Upload de Imagem !')
                    ->withInput();
        }

        $this->image      = $newNameFile;
        $this->is_admin   = ($request->is_admin) ? 1 : 0;

        return $this->save();
    }

    public function search($keySearch, $totalPage = 10) 
    {
        return $this
            ->where('name', 'LIKE', "%{$keySearch}%")
            ->orWhere('email', $keySearch)
            ->paginate($totalPage);
    }

    public function reserves()
    {
        return $this->hasMany(Reserve::class);
    }
}
