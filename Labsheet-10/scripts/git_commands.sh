#!/bin/bash
# Q1 & Q2: Git setup, branch creation, conflict resolution & pushing

# 1. Initialize Git repository
git init
git branch -M main

# 2. Add files and commit
git add .
git commit -m "chore: initial project architecture and setup"

# 3. Create feature branch
git checkout -b feature/product-api
echo "// feature change" >> controllers/ProductController.php
git commit -am "feat: added new feature logic"

# 4. Merge back to main
git checkout main
git merge feature/product-api

# 5. Push to GitHub
git remote add origin https://github.com/yourusername/mca108p-lab10.git
git push -u origin main
