# Badania API — Development Setup & Docker

## 📦 Wymagania wstępne

- Docker i Docker Compose zainstalowane na Twoim systemie
- Plik `.env` skonfigurowany (można skopiować z `.env.example`)

## 🔧 Budowanie kontenerów

W pierwszej kolejności zbuduj obrazy dockera:

```bash
docker-compose build
```

## 🔧 Uruchamianie kontenera
Aby uruchomić aplikację w tle wpisujemy:

```bash
docker-compose up -d
```

## ⚙️ Inicjalizacja bazy danych

Aby zainicjalizować baze danych przykładowymi danymi uruchom:

```bash
docker-compose exec app php artisan migrate --seed
```

## 📘 Generowanie dokumentacji (Swagger)

Aby wygenerować dokumentacje API uruchamiamy:
```bash
docker-compose exec app php artisan l5-swagger:generate
```
Po wygenerowaniu dokumentacji, będzie ona dostępna pod adresem:

[http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

Pod tym adresem będzie mozliwe przetestowanie API


