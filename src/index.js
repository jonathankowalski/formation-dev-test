import request from 'superagent'
import Mustache from 'mustache'

const echeance = document.getElementById('echeance')
const revenus = document.getElementById('revenus')
const taux = document.getElementById('taux')
const tauxFace = document.getElementById('taux-face')
const templateCard = document.getElementById('card-template').innerHTML
const cardsContainer = document.getElementById('cards')

Mustache.parse(templateCard)

let typingTimer = false
let typing = false
let pretTimer = false

const getEcheance = async montant => {
  const res = await request
    .post('/echeance')
    .send({ montant: montant })
  return res.body.montant
}

const getPret = async (echeance, taux, months) => {
  const res = await request
    .post('/pret')
    .send({ echeance: echeance, taux: parseFloat(taux)/100, months: months })
  return res.body.montant
}

const letsUpdate = () => {
  clearTimeout(pretTimer)
  pretTimer = setTimeout(() => {
    updatePretCards()
  }, 1000)
}

const updatePretCards = () => {
  while(cardsContainer.firstChild) {
    cardsContainer.removeChild(cardsContainer.firstChild)
  }
  for (let i = 2; i < 5; i++) {
    updatePretCard(echeance.value, taux.value, i*5*12)
  }
}

const updatePretCard = async (echeance, taux, months) => {
  const montant = await getPret(echeance, taux, months)
  const rendered = Mustache.render(templateCard, {
    years: months/12,
    montant: new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR'}).format(montant)
  })
  const div = document.createElement('div')
  div.innerHTML = rendered
  console.log(rendered)
  cardsContainer.appendChild(div)
}

revenus.addEventListener('keyup', event => {
  if (typingTimer !== false) {
    window.clearTimeout(typingTimer)
  }
  typingTimer = window.setTimeout(async () => {
    typing = true
    echeance.value = await getEcheance(event.target.value)
    letsUpdate()
  }, 1000)
})

revenus.addEventListener('click', async event => {
  if (!typing) {
    echeance.value = await getEcheance(event.target.value)
    letsUpdate()
  }
})

tauxFace.innerText = taux.value
taux.addEventListener('change', event => {
  tauxFace.innerText = event.target.value
  letsUpdate()
})
