FROM defrostedtuna/php-nginx:8.1-dev

# Git and OpenSSH are needed for the Remote Containers setup.
RUN apk add --no-cache \
  php81-redis \
  git \
  openssh

# Let's make the terminal look nicer.
RUN echo 'export PS1="┌─ 🐳 \[\e[0;1;30;43m\] \u \[\e[0m\]\[\e[0;1;30;46m\] \h \[\e[0m\]\[\e[0;1;30;47m\] \w \[\e[0m\] \n└─ $ "' >> /etc/profile