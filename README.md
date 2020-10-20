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
$di->handle(function (Service $service, $a, $b) {}, [
  '$b' => 123,
  '$a' => '123',
    Service::class => new Service()
  ]);
```

### Виды провайдеров:
1. Provider - обычный файл настройки модуля, используя метод register() удобно задавать бинды, фабрики и синглтоны
2. BootableProvider - поддерживает метод boot(), который будет вызван, когда приложение сделает $di->boot(), а в случае, если уже был сделан - то немедленно после регистрации провайдера
3. DeferableProvider - изменяет поведение метода boot() таким образом, что он вызывается в тот момент, когда инжектор пытается создать класс. Для указания, на какие именно классы он сработает используется метод provides().

### Основные возможности:
```
public function boot();
public function isBooted() : bool;

public function get($id);
public function getOrFail(string $id);
public function createAutowired(string $id, ...$arguments);
public function createAutowiredOrFail(string $id, ...$arguments);

public static function find(string $id)
public static function findOrFail(string $id)
public static function make(string $id, ...$arguments)
public static function makeOrFail(string $id, ...$arguments)

public function has($id);

public function set(string $id, $item);
public function setOrFail(string $id, $item);

public function replace(string $id, $item);

public function bind(string $id, $bind, bool $shared = false);
public function bindShared(string $id, $bind);
public function singleton(string $id, $item);

public function rebind(string $id, $bind, bool $shared = false);
public function rebindShared(string $id, $item);

public function extend(string $id, $func);

public function registerProvider($provider);
public function removeProvider($provider);

public function handle($func, ...$arguments);
public function call($newthis, $func, ...$arguments);
```

### Исключения
* Если бинд не был зарегистрирован, будет выброшено исключение
* Если при указании зависимостей была допущена рекурсия, будет выброшено исключение.
