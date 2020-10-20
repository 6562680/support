# di

Контейнер с инжектором зависимостей

### Инжектор это:
0. Привязка к Psr/ContainerInterface и Psr/NotFoundException
1. Это автоматическая подстановка аргументов в конструктор класса или в вызов функции через  методы ::make($id), ->get($id), create($id, ...$args), handle($func, ...$args), call($newthis, $func, ...$args)
2. Универсальная фабрика. bind() регистрирует класс/замыкание, которое будет вызвано каждый раз при обращении по ключу. С помощью интерфейсов или строк можно регистрировать сколько угодно фабрик одного и того же класса
3. Единое хранилище для паттернов Одиночка. Вместо хранения одиночек внутри самих себя, можно хранить их в одном контейнере, имея возможность очищать память, когда те уже не требуются
4. Это предзагрузка данных перед использованием класса. Используя методы boot() в провайдерах можно загружать дополнительные данные, когда этот обьект требуется, а если у модуля есть "провайдер" - то его подключение в другую программу становится удовольствием
5. Это копирование файлов из модулей в ядро проекта через те же самые провайдеры и метод sync()
6. Это возможность передать в вызываемый метод аргументы через специальный синтаксис без учета порядка их следования:
```
<?php
$service = new Service(),
$di->handle(function (Service $service, $a, $b) {}, [
  '$b' => 123,
  '$a' => '123',
  
  Service::class => $service
]);
```

### Виды провайдеров:
1. Provider - обычный файл настройки модуля, используя метод register() удобно задавать бинды, фабрики и синглтоны
2. BootableProvider - поддерживает метод boot(), который будет вызван, когда приложение сделает $di->boot(), а в случае, если уже был сделан - то немедленно после регистрации провайдера
3. DeferableProvider - изменяет поведение метода boot() таким образом, что он вызывается в тот момент, когда инжектор пытается создать класс. Для указания, на какие именно классы он сработает используется метод provides().

### Исключения
* При попытке зарегистрировать бинд повторно без использования replace()/rebind() будет выброшено `Gzhegow\Di\Exceptions\Runtime\OverflowException`
* Если бинд не был зарегистрирован, но вы попытались его получить, будет выброшено `Gzhegow\Di\Exceptions\Error\NotFoundError`
* Если при автоматическом инжектировании параметр невозможно предсказать, будет выброшено `Gzhegow\Di\Exceptions\Runtime\Error\AutowireError`
* Если при указании зависимостей была допущена рекурсия, будет выброшено `Gzhegow\Di\Exceptions\Runtime\Error\AutowireLoopError`

### Основные возможности:
```
public static function getInstance(); // получить экземпляр контейнера в произвольном месте кода. Паттерн Одиночка

public function get($id); // получить объект, если синглтон, следующий раз вернется тот же обьект
public function getOrFail(string $id); // получить объект, если синглтон, следующий раз вернется тот же обьект
public function create(string $id, ...$arguments); // создать обьект, игнорируя синглтоны
public function createOrFail(string $id, ...$arguments); // создать обьект, игнорируя синглтоны


public static function find(string $id) // получить объект, если синглтон, следующий раз вернется тот же обьект
public static function findOrFail(string $id) // получить объект, если синглтон, следующий раз вернется тот же обьект
public static function make(string $id, ...$arguments) // создать обьект, игнорируя синглтоны
public static function makeOrFail(string $id, ...$arguments) // создать обьект, игнорируя синглтоны


public function handle($func, ...$arguments); // вызвать замыкание, используя автоподстановку
public function call($newthis, $func, ...$arguments); // вызвать замыкание от имени обьекта, позволив установить защищенные свойства (read-only properties)


public function bind(string $id, $bind, bool $shared = false);
public function bindShared(string $id, $bind);
public function singleton(string $id, $item);

public function rebind(string $id, $bind, bool $shared = false);
public function rebindShared(string $id, $item);


public function set(string $id, $item); // сохранить произвольные данные в контейнер, чтобы потом пользоваться через get()
public function setOrFail(string $id, $item); // сохранить произвольные данные в контейнер, чтобы потом пользоваться через get()

public function replace(string $id, $item); // принудительно переписать старый сет на новый


public function has($id); // проверить наличие бинда или сета


public function extend(string $id, $func); // после создания обьекта вызвать замыкание, чтобы обернуть его, можно добавить несколько декораторов


public function registerProvider($provider); // зарегистрировать провайдер
public function removeProvider($provider); // удалить провайдер и его бинды из регистра


public function boot(); // запустить загрузку BootableProvider-ов
public function isBooted() : bool; // проверить, была ли загрузка уже запущена ранее
```
