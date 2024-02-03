import smtplib, ssl
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart
from os import listdir
from os.path import isfile, join

def sendMail(title, newMessage):   
  port = 465 
  smtp_server = "smtp.gmail.com"
  sender_email = "durablemail78@gmail.com" 
  receiver_email = "phamkhapanda@gmail.com" 
  password = "lgdb zicv agcl jzfc"

  message = MIMEMultipart("alternative")
  message["Subject"] = "Nouvelle DurableMail - "+title
  message["From"] = sender_email
  message["To"] = receiver_email


  text = newMessage


  partText = MIMEText(text, "plain")

  message.attach(partText)

  context = ssl.create_default_context()
  with smtplib.SMTP_SSL("smtp.gmail.com", 465, context=context) as server:
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
    if isTitle:
      title = line
      isTitle = False
    text+=line

  return title,text


path = ".\\articles"

for f in listdir(path):
  if isfile(join(path, f)):
    print(join(path, f))
    title, text=readArticle(join(path, f))
    sendMail(title, text)