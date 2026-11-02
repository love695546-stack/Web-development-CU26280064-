from sqlalchemy import create_engine, String, Integer
from sqlalchemy.orm import DeclarativeBase, Mapped, mapped_column, Session

# Replace credentials. URL format: mysql+pymysql://user:password@host/database
engine = create_engine(
    "mysql+pymysql://root:CU26280064@localhost/python_web_db",
    echo=True
)

class Base(DeclarativeBase):
    pass

class User(Base):
    __tablename__ = "users"
    id: Mapped[int] = mapped_column(Integer, primary_key=True, autoincrement=True)
    name: Mapped[str] = mapped_column(String(100))
    email: Mapped[str] = mapped_column(String(150), unique=True)
    age: Mapped[int] = mapped_column(Integer)

Base.metadata.create_all(engine)

with Session(engine) as session:
    user = User(name="Neha", email="neha@example.com", age=22)
    session.add(user)
    session.commit()
    print("User added with ID:", user.id)
