# di

Классический, максимально простой, контейнер с инжектором зависимостей

Я предпочел удалить "лишний" функционал, который предоставляют большинство контейнеров, по полному конфигурированию вызываемых методов и их аргументов. 90% времени моей работы мне требовалось подставлять аргументы в функции-замыкания и в конструкторы, остальные задачи решались через декорирование уже объявленных биндов.

Если внедрять полное конфигурирование методов, то инжектор зависимостей становится еще и диспетчером, и теоретически позволит на каждый метод повесить неограниченное количество событий, когда ценой скорости работы модуля мы увеличиваем кратковременный потенциал изменения методов, не редактируя сами классы.

В будущем это грозит тем, что вы действительно не будете понимать кто и каким образом подменил результат вызываемого метода, а кроме того почти все методы программы придется пробрасывать через этот инжектор. Для меня потеря производительности это более весомый аргумент, чем возможность в будущем создать себе проблему по поиску цепочки и виновника, который все сломал.

Данный контейнер предоставляет следующие функции:
```
bind(string $id, string|closure $bound) // с помощью нее мы указываем по какому классу или интерфейсу нужно достать какой обьект из контейнера
set(string $id, mixed $value) // в отличие от функции bind() устанавливает реальный обьект, строку или любое значение в качестве результата работы инжектора
```

Для того, чтобы настраивать вашу программу, предусмотрены т.н. Провайдеры - считайте их файлами настройки Инжектора. Написали класс провайдера, указали внутри бинды и сеты, добавили провайдер в инжектор. Бинды теперь будут доступны из контейнера.

Провайдеры предоставляют два способа загрузки - Автозагрузка и Загрузка по запросу.

Автозагрузка означает, что функция boot() каждого провайдера будет выполнена в момент, когда вы вызовете на контейнере метод ->boot(). В этом методе обычно устанавливают настройки ваших обьектов-синглтонов и другие статические опции, которые будут нужны позже. Почему бы это не делать сразу при добавлении обьекта в контейнер? Обычно метод boot() вызывается тогда, когда все бинды уже зарегистрированы, чтобы избежать проблемы "вы запросили класс, о котором я не знаю"

К сожалению, некоторые обьекты при настройке делают дополнительные запросы в другие источники данных - базы, апи и остальные, что может быть затратно по времени, если делать это каждый раз. Для этого предоставляется отложенная загрузка по запросу - в момент когда инжектор попробует создать указанный обьект - будут выполнены функции настройки из провайдера.

Дальнейший потенциал доработки такого инжектора - автоматическая обертка всех подбрасываемых зависимостей в обьекты-обещания (промизы), которые будут выполнять загрузку настроек не в момент подбрасывания обьекта в конструктор, а непосредственно в момент первого обращения к обьекту для вызова какого-либо метода. Однако, это увеличит количество методов вида `__call` и `__callStatic`, и замедлит работу приложения на поиск доступных для вызова методов.
