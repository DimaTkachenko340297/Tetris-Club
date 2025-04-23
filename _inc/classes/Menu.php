<?php

class Menu
{
    // Переменная для хранения элементов меню
    private $menuItems;

    // Конструктор, который позволяет установить элементы меню при создании объекта
    public function __construct($menuItems = [])
    {
        // Если элементы меню пустые, устанавливаем элементы по умолчанию
        if (empty($menuItems)) {
            $menuItems = [
                ['label' => '', 'link' => 'index.php', 'icon' => 'fas fa-home'],
                ['label' => '', 'link' => 'galeria.php', 'icon' => 'fas fa-briefcase'],
                ['label' => '', 'link' => 'o_nas.php', 'icon' => 'fas fa-question-circle'],
                ['label' => '', 'link' => 'kontakt.php', 'icon' => 'fas fa-envelope']
            ];
        }
        
        // Сохранение элементов меню
        $this->menuItems = $menuItems;
    }

    // Метод index() для получения элементов меню
    public function index()
    {
        return $this->menuItems;
    }
}
?>
