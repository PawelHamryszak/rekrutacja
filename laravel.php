<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Route;

class Client extends Model
{
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

class Employee extends Model
{
    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}

class Order extends Model
{
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

class User extends Authenticatable
{
    public function cars()
    {
        return $this->belongsToMany(Car::class);
    }
}

class Car extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

class UserAssignedToCarNotification extends Notification
{
    protected $car;

    public function __construct(Car $car)
    {
        $this->car = $car;
    }
}

// Pobieranie informacji o kliencie, pracowniku i zamówieniach
$clientId = 1;
$client = Client::with('employee', 'orders')->find($clientId);
$employee = $client->employee;
$orders = $client->orders()->latest()->limit(5)->get();

// Przypisanie użytkownika do samochodu i weryfikacja
$userId = 1;
$carId = 1;

$user = User::find($userId);
$car = Car::find($carId);

$user->cars()->attach($carId);
$user->cars()->detach($carId);

$usesCar = $user->cars()->where('car_id', $carId)->exists();

// Tworzenie testu HTTP
Route::post('/vehicles', function () {
    // Logika tworzenia pojazdu

    return response()->json([
        'name' => 'Car 1',
        'type' => 'Sedan',
    ], 201);
});

// System notyfikacji
$car = Car::find($carId);
$user->notify(new UserAssignedToCarNotification($car));
