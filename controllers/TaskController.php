<?php
namespace Controllers;

class TaskController
{
    protected const WHITE_LIST_ORDER = [
        'id',
        'email',
        'text',
        'user_name'
    ];

    protected const ADD_VALIDATE = [
        'user_name' => [
            'required',
            'string',
        ],
        'text' => [
            'required',
            'string',
        ],
        'email' => [
            'required',
            'string',
            'email',
        ],
    ];

    protected const UPDATE_VALIDATE = [
        'id' => [
            'required',
            'int',
        ],
        'text' => [
            'required',
            'string',
        ],
        'status' => [],
        'textPred' => [],
        'text_change' => []
    ];

    /**
     * Модель "Задачи"
     * @var \Models\Task $taskModel
     */
    protected \Models\Task $taskModel;

    /**
     * Данные отправленные пользователем
     * @var array $data
     */
    protected array $data;

    /**
     * Сообщение пользователю
     * @var string $message
     */
    protected string $message;

    /**
     * Поле сортировки
     * @var string $order
     */
    protected string $order;

    /**
     * Порядок сортировки
     * @var string $by
     */
    protected string $by;


    public function __construct()
    {
        $this->taskModel = new \Models\Task();
    }

    /**
     * Получение списка "Задач"
     * @throws \Exception
     */
    public function listAction( string $order = 'id', string $by = 'desc' )
    {
        $pagination = new \yidas\data\Pagination([
            'totalCount' => ($this->taskModel->getCount()->fetch())['count'],
            'perPage' => 3
        ]);

        $this->validateOrder($order, $by);

        $rows = $this->taskModel->getList($pagination->limit, $pagination->offset, $this->order, $this->by);

        $by = $this->by == 'asc' ? 'desc' : 'asc';
        $access = $_SESSION['auth'] ?? false;

        include 'views/tasks/list.php';
    }

    /**
     * Валидация сортировки
     * @param string $order
     * @param string $by
     */
    protected function validateOrder( string $order, string $by )
    {
        if(
            in_array( $order, self::WHITE_LIST_ORDER )
            AND
            in_array( $by, ['asc', 'desc'] )
        ) {
            $this->order = $order;
            $this->by = $by;
        }
    }

    /**
     * Форма для добавления "Задачи"
     */
    public function formAddAction()
    {
        include 'views/tasks/add.php';
    }

    /**
     * Добавление "Задачи"
     * @throws \Exception
     */
    public function addAction()
    {
        $this->data = $_POST;

        if( ! $this->validate(self::ADD_VALIDATE) ) {
            die('<div class="bg-danger">' . $this->message . '</div>');
        }

        if( ! $this->taskModel->add($this->data['user_name'], $this->data['email'], $this->data['text']) ) {
            die('<div class="bg-danger">Ошибка добавления элемента, проверьте введённые данные.</div>');
        }

        print('<div class="bg-success">Успешно</div>');
    }

    /**
     * Форма для изменения "Задачи"
     * @throws \Exception
     */
    public function updateFormAction( int $id )
    {
        $item = $this->taskModel->getById($id);

        include 'views/tasks/update.php';
    }

    /**
     * Изменение "Задачи"
     * @throws \Exception
     */
    public function updateAction()
    {
        $this->data = $_POST;

        $access = $_SESSION['auth'] ?? 'false';
        if( $access ) {
            die('<div class="bg-danger">Ошибка нужно авторизоваться</div>');
        }

        if( ! $this->validate(self::UPDATE_VALIDATE) ) {
            die('<div class="bg-danger">' . $this->message . '</div>');
        }

        $status = ( empty($this->data['status']) ) ? 'null' : 'true';

        $textChange = $this->data['text_change'] ? 'true' : 'null';
        if( empty($this->data['text_change']) )
            $textChange = ($this->data['text'] == $this->data['textPred']) ? 'null' : 'true';

        if( ! $this->taskModel->update($this->data['text'], $status, $this->data['id'], $textChange) ) {
            die('<div class="bg-danger">Ошибка изменения элемента, проверьте введённые данные.</div>');
        }

        print('<div class="bg-success">Успешно</div>');
    }

    /**
     * Валидация данных
     * @param array $validates
     * @return false|void
     */
    public function validate( array $validates ): bool
    {
        foreach ($this->data as $key => $item) {

            foreach ($validates[$key] as $validate) {

                if($validate == 'required') {
                    if( empty($item) ) {
                        $this->message = 'Заполните все обязательные поля';
                        return false;
                    }
                }

                if($validate == 'email') {
                    if( ! filter_var($item, FILTER_VALIDATE_EMAIL)){
                        $this->message = 'Ошибка заполнения почты. Почта должна содержать @ и .com/.ru/..';
                        return false;
                    }
                }

                if($validate == 'string') {
                    $this->data[$key] = $this->shielding($item);
                }

                if($validate == 'int') {
                    if( ! $this->data[$key] = intval($item) ) {
                        $this->message = 'Ошибка поле ' . $key  . ' должно быть числом';
                        return false;
                    }
                }
            }
        }
        return true;
    }

    public function shielding($data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}