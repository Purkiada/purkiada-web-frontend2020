import re
import os
import yaml

template = yaml.load(open("template.yml"))

targets = ["prihlaska.html", "zadani.html", "404.html", "403.html", "50x.html"]

for root, dirs, files in os.walk("purkiada/"):
    for file in files:
        targets.append(os.path.join(root, file))


for target in targets:
    print("Target:",target,"... ", end="")
    f = open(target)
    content = f.read()
    f.close()

    find = re.search("\s+<head>\n\s+<meta charset=\"utf-8\">\n\s+<title>(.+)</title>\n((?:.*\n)+)\s+</head>", content);
    content = content.replace(find[2], template["head"].replace("\\t", "  "))

    find = re.search("\s+<nav>\n((?:.*\n)+)\s+</nav>", content);
    content = content.replace(find[1], template["nav"].replace("\\t", "  "))

    f = open(target, mode="w")
    f.write(content)
    f.close()
    print("DONE")
