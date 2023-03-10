# /src/domain - слой доменной логики (предметной области), чистой бизнес логики без привязки к фреймворку

Этот
каталог
содержит
исходные
файлы
слоя
доменной
логики (
предметной
области)
,
чистой
бизнес
логики
без
привязки
к
фреймворку.
В
данном
слое
реализуются
сущности,
объекты-значения,
агрегаты
и
прочие
элементы
предметной
области.
Каждая
сущность
должна
быть
вынесена
в
отдельную
директорию,
где
располагаются
все
необходимые
элементы
для
ее
работы.

## Файловая структура

```
/src/domain:  слой доменной логики (предметной области), чистой бизнес логики без привязки к фреймворку
    - /entity: директория сущности
        - /value-objects: объекты-значения сущности
        - /enums: статичные данные (нумераторы/константы/перечисления) сущности
        - /events: события сущности
        - /exceptions: исключения сущности
```

**
Сущность (
entity)**
-
это
объект
из
предметной
области.
Сущность
обязательно
должна
иметь
идентификатор.

**
Объект-значение (
value
object)**
-
это
строительный
блок
сущности.
Объект-значение
не
имеет
идентификатор
и
обладает
стабильным
содержимым
на
все
время
жизни.

**
Константы/перечисления/нумераторы (
enums)**
-
статичные
данные
сущности.
Данные
объекты
предназначены
для
хранения
постоянных
данных,
которыми
будет
оперировать
сущность.