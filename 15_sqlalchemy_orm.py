# Q15: SQLAlchemy ORM - map a Python class to the MySQL 'users' table.
# Install first:  pip install SQLAlchemy mysql-connector-python
from datetime import datetime
from typing import Optional
from sqlalchemy import create_engine, String, func, select
from sqlalchemy.orm import DeclarativeBase, Mapped, mapped_column, Session
from db_config import DB_CONFIG

url = (f"mysql+mysqlconnector://{DB_CONFIG['user']}:{DB_CONFIG['password']}"
       f"@{DB_CONFIG['host']}/{DB_CONFIG['database']}")
engine = create_engine(url)


class Base(DeclarativeBase):
    pass


class User(Base):                                   # class  <->  table
    __tablename__ = "users"
    id: Mapped[int] = mapped_column(primary_key=True, autoincrement=True)
    name: Mapped[str] = mapped_column(String(100))
    email: Mapped[str] = mapped_column(String(100), unique=True)
    age: Mapped[Optional[int]]
    created_at: Mapped[Optional[datetime]] = mapped_column(server_default=func.now())

    def __repr__(self):
        return f"User(id={self.id}, name={self.name!r}, email={self.email!r}, age={self.age})"


Base.metadata.create_all(engine)                    # creates the table only if missing

with Session(engine) as session:
    # CREATE
    new_user = User(name="Tarun Bisht", email="tarun@example.com", age=26)
    session.add(new_user)
    session.commit()
    print("Created:", new_user)

    # READ
    for user in session.scalars(select(User).where(User.age >= 22).order_by(User.name)):
        print("Found  :", user)

    # UPDATE
    new_user.age = 27
    session.commit()
    print("Updated:", new_user)

    # DELETE
    session.delete(new_user)
    session.commit()
    print("Deleted the demo user.")
