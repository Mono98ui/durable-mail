import smtplib, ssl
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart

port = 465 
smtp_server = "smtp.gmail.com"
sender_email = "durablemail78@gmail.com" 
receiver_email = "phamkhapanda@gmail.com" 
password = "lgdb zicv agcl jzfc"

message = MIMEMultipart("alternative")
message["Subject"] = "Nouvelle DurableMail"
message["From"] = sender_email
message["To"] = receiver_email

newMessage = "Hello world"

text = """\
Bonjour,
"""+newMessage


partText = MIMEText(text, "plain")

message.attach(partText)

context = ssl.create_default_context()
with smtplib.SMTP_SSL("smtp.gmail.com", 465, context=context) as server:
    server.login(sender_email, password)
    server.sendmail(
        sender_email, receiver_email, message.as_string()
    )