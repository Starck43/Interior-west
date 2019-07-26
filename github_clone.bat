alias Projects='Projects' 
//alias storm='/c/Program\ Files\ \(x86\)/JetBrains/PhpStorm\ 2016.1.1/bin/PhpStorm.exe' $*

# Переходим в папку с проектами
# Клонируем стартовый шаблон с гитхаба во временную папку $2 - название проекта 
git clone https://github.com/Starck43/Start-WP-Template.git $2_temp
cd $2_temp
# Переносим шаблон с переименовываем названия шаблона на $2
mv $2_temp/Start-WP-Template $2
# Удаляем временный шаблон
rm $2_temp
# Переходим в папку $2    
cd $2
# Удаляем папку с гитом    
rm -rf .git
# Создаем папку для исходников(макеты, логотипы и прочее)    
mkdir source
# ставим WordPress
# Линкуем глобальные пакеты
npm i
# Открываем проект на виртуальном сервере
# storm $2
# Запускаем gulp(или npm run start)    
gulp