from mjpegtools import MjpegParser
from datetime import datetime


image = MjpegParser(url='http://cdn1.webcams.bg:8554/kuban.mjpg').serve()   # Download the photo

date = datetime.today().replace(microsecond=0)  # Get date and time for filename
fn = (str(date) + '.jpg').replace(':', '.')  # Set the filename

with open(fn, 'wb') as im:  # Open file
  im.write(image.output.read())  # Write photo to the file

