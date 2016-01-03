#!/bin/bash

mysql -uroot -pempty -e 'CREATE DATABASE IF NOT EXISTS `collision` CHARACTER SET `utf8` COLLATE `utf8_bin`;'