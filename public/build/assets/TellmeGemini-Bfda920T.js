import{T as _,z as v,p as h,c as n,a as p,u as t,w as c,F as g,o as r,Z as b,b as s,d as q,e as w,f as y,v as k,n as S,t as u,g as T,r as V}from"./app-DnbpX7FN.js";import{_ as N}from"./AuthenticatedLayout-CkvLD6vU.js";import"./ApplicationLogo-Dj5uMDEf.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const R={class:"py-12"},A={class:"mx-auto max-w-7xl sm:px-6 lg:px-8"},B={class:"overflow-hidden bg-white shadow-sm sm:rounded-lg"},C={class:"p-6 text-gray-900"},F={class:"mt-4"},G={key:0,class:"text-red-500"},M=["disabled"],L={__name:"TellmeGemini",props:{geminiResponse:{type:String,required:!1}},setup(f){const a=f,e=_({question:""});let i=v([]);h(()=>{a.geminiResponse&&i.value.push(a.geminiResponse)});const x=()=>{if(console.log(e.question),e.question=e.question.trim(),e.question.length===0){e.errors.question="Invalid submission";return}e.post(route("tell.get-from-gemini"),{preserveState:!0,onSuccess:()=>{i.value=[...i.value,a.geminiResponse],e.question=""},onError:m=>{console.log(m)}})};return(m,o)=>(r(),n(g,null,[p(t(b),{title:"Ask Gemini"}),p(N,null,{header:c(()=>o[1]||(o[1]=[s("h2",{class:"text-xl font-semibold leading-tight text-gray-800"}," Tell me Gemini ",-1)])),default:c(()=>[s("div",R,[s("div",A,[s("div",B,[s("div",C,[o[2]||(o[2]=q(" Ask gemini what you want ")),s("div",F,[s("form",{onSubmit:w(x,["prevent"])},[s("div",null,[y(s("textarea",{"onUpdate:modelValue":o[0]||(o[0]=l=>t(e).question=l),rows:"5",class:S(["input bg-white border-primary block mt-2 w-full max-w-2xl",{"is-invalid":t(e).errors.name}]),type:"text",id:"question"},null,2),[[k,t(e).question]]),t(e).errors.question?(r(),n("span",G,u(t(e).errors.question),1)):T("",!0)]),s("button",{class:"btn btn-primary mt-2",type:"submit",disabled:t(e).processing||t(e).question.trim().length===0}," Send ",8,M)],32)]),s("ul",null,[(r(!0),n(g,null,V(t(i),(l,d)=>(r(),n("li",{key:d},u(d)+" - "+u(l),1))),128))])])])])])]),_:1})],64))}};export{L as default};
