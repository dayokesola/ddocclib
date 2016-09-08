<?php

namespace com\yum;

class YumService {

    public static function CreateMVC($entity) {
        $view_dir = VIEWS . $entity;
        UtilService::CreateFolder($view_dir);
        //views
        $view = CodeService::GetCode($entity,'view_create');
        UtilService::CreateFile($view_dir . '\\create.php', $view);
        $view = CodeService::GetCode($entity,'view_edit');
        UtilService::CreateFile($view_dir . '\\edit.php', $view);
        $view = CodeService::GetCode($entity,'view_index');
        UtilService::CreateFile($view_dir . '\\index.php', $view);
        $view = CodeService::GetCode($entity,'view_delete');
        UtilService::CreateFile($view_dir . '\\delete.php', $view);
        //controller
        $ctrl_dir = APPLIB .'com\\' . APP. '\\controller';
        //UtilService::CreateFolder($ctrl_dir);
        $view = CodeService::GetCode($entity,'class_controller');
        UtilService::CreateFile($ctrl_dir . '\\'.  NameService::ControllerName($entity) . '.php', $view);
        
        //service
        $serv_dir = APPLIB .'com\\' . APP. '\\service';
        //UtilService::CreateFolder($serv_dir);
        $view = CodeService::GetCode($entity,'class_service');
        UtilService::CreateFile($serv_dir . '\\'.  NameService::ServiceName($entity) . '.php', $view);
        
        //dto
        $dto_dir = APPLIB .'com\\' . APP. '\\dto';
        //UtilService::CreateFolder($dto_dir);
        $view = CodeService::GetCode($entity,'class_dto');
        UtilService::CreateFile($dto_dir . '\\'.  NameService::DTOName($entity) . '.php', $view);
        
        
        //entity
        $ent_dir = APPLIB .'com\\' . APP. '\\entity';
        //UtilService::CreateFolder($ent_dir);
        $view = CodeService::GetCode($entity,'class_entity');
        UtilService::CreateFile($ent_dir . '\\'.  NameService::EntityName($entity) . '.php', $view);
    }

}
