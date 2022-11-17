# Pull base image
FROM python:3.10.5

# Set environmental variables
ENV PYTHONDONTWRITEBYTECODE 1
ENV PYTHONUNBUFFERED 1

# Set work directory
WORKDIR /sport247

# Install dependencies
COPY Pipfile Pipfile.lock requirements.txt /sport247/
RUN pip3 install pipenv && pipenv install --system && pip3 install -r requirements.txt

# Copy project
COPY .env /sport247/
COPY . /sport247/