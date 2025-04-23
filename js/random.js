const fortunes = [
    { src: 'img/item0.png', text: 'a «T»!' },
    { src: 'img/item1.png', text: 'a «S»!' },
    { src: 'img/item2.png', text: 'a «Z»!' },
    { src: 'img/item3.png', text: 'a «I»!' },
    { src: 'img/item4.png', text: 'a «L»!' },
    { src: 'img/item5.png', text: 'a «J»!' },
    { src: 'img/item6.png', text: 'a «O»!' }
];

const randomIndex = Math.floor(Math.random() * fortunes.length);

document.getElementById('fortune-image').src = fortunes[randomIndex].src;
document.getElementById('fortune-text').textContent = `Today you are ${fortunes[randomIndex].text}`;