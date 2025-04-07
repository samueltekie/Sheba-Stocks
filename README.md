# Sheba-Stocks
# 📈 Sheba Stocks – Ethiopia’s First Digital Stock Trading Platform

Sheba Stocks is a graduation project built by computer science students at Debre Berhan University. It aims to simulate and eventually support real-time digital stock trading in Ethiopia, in alignment with the launch of the Ethiopian Securities Exchange (ESX). This Laravel-based platform enables users to manage portfolios, place mock trades, and learn the basics of investing in a local context.

---

## 🚀 Tech Stack

- **Backend**: Laravel 10 (PHP)
- **Frontend**: React.js *(connected frontend coming soon)*
- **Database**: MySQL
- **Styling**: Tailwind CSS
- **Real-Time Updates**: WebSocket
- **Dev Tools**: Vite, Postman, GitHub, Figma

---

## 📁 Project Structure

```
├── app/               # Core logic (Models, Controllers, etc.)
├── routes/            # Laravel route files
├── public/            # Publicly accessible files
├── resources/         # Views and frontend assets
├── tests/             # Test suite
├── config/            # App configuration
├── .env.example       # Environment sample file
```

---

## 🛠️ Getting Started

```bash
git clone https://github.com/samueltekie/Sheba-Stocks.git
cd Sheba-Stocks
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan serve
```

---

## 👨‍💻 Team Members

- **Samuel Tekie** – Backend Lead  
- **Mekides Marie** – Frontend / UI/UX  
- **Firomsa Fekadu** – Full-stack Developer  
- **Abayneh Bekele** – DevOps & Integration

---

## 📊 Features

- ✅ User registration & login  
- ✅ Virtual portfolio & wallet system  
- ✅ Stock order simulation  
- ✅ Real-time updates *(with WebSocket)*  
- 🧠 Market analytics *(in progress)*  
- 💼 Admin dashboard *(coming soon)*

---

## 📄 License

This project is open-source and licensed under the MIT License.
