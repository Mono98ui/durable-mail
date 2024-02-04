import smtplib, ssl
import random
import os
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart
from os import listdir
from os.path import isfile, join
from env import initVariable 

def sendMail(newMessage, mailReceiver):   
  port = int(os.environ["port"]) 
  smtp_server = os.environ["smtpServer"]
  sender_email = os.environ["senderEmail"]
  receiver_email = mailReceiver 
  password = os.environ["senderEmailPwd"]

  message = MIMEMultipart()
  message["Subject"] = "Nouvelle Journal Vert"
  message["From"] = sender_email
  message["To"] = receiver_email

  html = """\
  {}
""".format(newMessage)


  partHTML = MIMEText(html, "html")

  message.attach(partHTML)

  context = ssl.create_default_context()
  with smtplib.SMTP_SSL(smtp_server, port, context=context) as server:
      server.login(sender_email, password)
      server.sendmail(
          sender_email, receiver_email, message.as_string()
      )


def readArticle(filePath):
  file = open(filePath, "r")
  text = ""
  isTitle = True
  title = ""

  for line in file:
    text+=line

  return text

def sendArticles(pathArticles, mailReceiver):

  listDirPath = listdir(pathArticles)

  if (len(listDirPath) >= 1):
    index = random.randrange(0, len(listDirPath))


    if isfile(join(pathArticles, listDirPath[index])):
      print(join(pathArticles, listDirPath[index]))
      text=readArticle(join(pathArticles, listDirPath[index]))
      sendMail(text, mailReceiver)

initVariable()
pathArticles = os.environ["pathArticles"]
pathMailList = os.environ["pathMailList"] 

fileEmail = open(pathMailList, "r")

for mail in fileEmail:
  if(mail.strip() != ""):
    print(mail.strip())
    sendArticles(pathArticles, mail.strip())

fileEmail.close()