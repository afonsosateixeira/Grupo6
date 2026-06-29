# Trabalho por estudante:

## Descrição:
Para facilidade de leitura estamos a demonstrar o que cada aluno fez usando o estilo de árvore de ficheiros visivel no Github, editores de texto como notepad e visual studio code.
Em caso de ficheiros de css e javascript, estamos a identificar o ficheiro principal afetado, como por exemplo:
```
site/
└──dia_voluntario.php
     ├──dia_voluntario.css
     └──dia_voluntario.js
```

Neste caso, embora os ficheiros dia_voluntário.css e dia_voluntário.js estejam atribuidos ao dia_voluntário estes encontram-se nas pastas de assets correspondentes. Exemplo da localização real:
```
site/
├──dia_voluntario.php
│
└──assets/
     ├──css/
     │    └──dia_voluntario.css
     └──js/
          └──dia_voluntario.js
```

A única exceção à pasta indicada acima são os assets do backoffice como exemplificado abaixo com a localização real. O mesmo aplica-se em ficheiros de componentes usando os assets da pasta origem, sendo esta "site" ou "backoffice".
```
site/
└──backoffice/
     ├──animalList.php
     │
     └──assets/
          ├──css/
          │    └──animalList.css
          └──js/
               └──animalList.js
```

## 2025178491_AfonsoTeixeira:
```
site/
├──accessibility.php
├──adoptionGuide.php
│    └──adoptionGuide.css
├──animalCatalog.php
│    └──animalCatalog.css
├──animalDetails.php
│    └──animalDetails.css
│
├──components/
│    ├──btn_adopt.php
│    ├──pagination.php
│    └──searchbar.php
│         └──searchbar.css
│
└──backoffice/
     ├──adoptionProcess.php
     │    └──adoptionProcess.js
     ├──animalList.php
     │    ├──animalList.css
     │    └──animalList.js
     │
     └──components/
          ├──action_adoption.php
          ├──action_animal.php
          ├──modal_adoption.php
          └──modal_animal.php
```

## 2025182402_DiogoAzevedo:
```
site/
├──dia_voluntario.php
│    ├──dia_voluntario.css
│    └──dia_voluntario.js
├──perfis_voluntario.php
│    └──perfis_voluntario.css
├──sobrenos.php
│    └──sobrenos.css
│
└──backoffice/
     ├──calendario_voluntarios.php
     │    └──calendario_voluntarios.css
     ├──listagemvoluntarios.php
     │    ├──listagemvoluntarios.css
     │    └──listagemvoluntarios.js
     │
     └──components/
          ├──action_calendario_voluntarios.php
          ├──action_voluntario.php
          ├──modal_calendario_voluntario.php
          └──modal_voluntario.php
```

## 2025115671_FranciscoMartins:
```
site/
├──animal_care.php
│    └──animal_care.css
├──appointment.php
│    ├──appointment.css
│    └──appointment.js
├──termos.php
│    └──termos.css
├──vetProfile.php
│    └──vetProfile.css
│
└──backoffice/
     ├──appointmentList.php
     │    └──appointmentList.js
     ├──medicalHistory.php
     │    └──medicalHistory.js
     ├──vetList.php
     │    ├──vetList.css
     │    └──vetList.js
     │
     └──components/
          ├──action_appointment.php
          ├──action_medicalHistory.php
          ├──action_vet.php
          ├──modal_appointments.php
          ├──modal_medicalHistory.php
          └──modal_vet.php
```

## 2025163132_GonçaloEstrelado:
```
site/
├──contactos.php
│    └──contactos.css
├──events.php
│
└──backoffice/
     ├──eventsList.php
     │    ├──eventsList.css
     │    └──eventsList.js
     │
     └──components/
          └──action_event.php
```

## 2025140801_HugoGiroto:
```
site/
├──donations.php
│    └──donations.css
├──privacy.php
│
└──backoffice/
     └──donationList.php
          └──donationList.js
```

## 2016112775_rubenreis:
```
site/
├──cookies.php
│    └──cookies.css
├──missing_animals.php
│    ├──missing_animals.css
│    └──missing_animals.js
├──notifications.php
│
└──backoffice/
     ├──missing_animals.php
     │    ├──missing_animals.css
     │    └──missing_animals.js
     │
     └──components/
          ├──action_missing.php
          └──modal_missing.php
```

## Grupo:
```
site/
├──assets/css/styles.css (Criado por Afonso e adições por Gonçalo e Rúben)
├──assets/js/scrits.js (Criado por Afonso)
│
├──.htaccess (Criado por Gonçalo e melhorado por Rúben)
├──404.php (Criado por Gonçalo)
├──config.php (Criado por Rúben)
├──db.php (Criado por Afonso)
├──forbidden.php
├──home.php (Design do Francisco e criado por Rúben)
│    └──home.css
├──index.php
├──login.php
├──regist.php
│
├──components/
│    ├──alerts.php (Criado por Afonso e adições por Diogo)
│    │    └──alerts.js
│    ├──footer.php (Criado por Afonso e correção por Hugo)
│    ├──head.php (Criado por Rúben e adições por Afonso)
│    ├──header.php (Criado por Afonso e adições por Rúben)
│    ├──helpers.php (Criado por Afonso)
│    ├──rerun.php (Criado por Rúben)
│    └──routing.php (Criado por Rúben, $path original por Gonçalo)
│
└──backoffice/
     ├──.htaccess (Criado por Rúben)
     ├──404.php (Criado por Gonçalo)
     ├──dashboard.php
     ├──index.php
     ├──user_list.php
     │    └──user_list.js
     │
     └──components/
          ├──action_users.php
          ├──modal_users.php
          └──sidebar.php (Criado por Afonso e adições do Hugo)
               └──sidebar.css
```