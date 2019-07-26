//alias Projects='Projects' 

# Переходим в папку с проектами Projects

# Клонируем стартовый шаблон Start-WP-Template с гитхаба в папку $2 - название проекта 
git clone https://github.com/Starck43/Start-WP-Template $2
cd $2
# Удаляем папку с гитом    
rm -r -f .git
# Создаем папку для исходников(макеты, логотипы и прочее)    
mkdir source
# ставим WordPress
# Линкуем глобальные пакеты
npm i
# Запускаем gulp(или npm run start)    
gulp