import{T as p,c as n,a,u as t,w as l,F as _,o as r,Z as g,b as s,d as x,e as b,f,v as h,n as w,t as d,g as m}from"./app-2pdxRjyw.js";import{_ as v}from"./AuthenticatedLayout-0FWKQnYW.js";import"./ApplicationLogo-DNj1p5CD.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const y={class:"py-12"},k={class:"mx-auto max-w-7xl sm:px-6 lg:px-8"},q={class:"overflow-hidden bg-white shadow-sm sm:rounded-lg"},V={class:"p-6 text-gray-900"},A={class:"mt-4"},F={key:0,class:"text-red-500"},N=["disabled"],S={class:"mt-4"},B={key:0},M={__name:"AskGemini",setup(C){const e=p({question:""}),u=()=>{console.log(e.question),e.post(route("gemini.store"),{onSuccess:()=>{console.log("Form submitted successfully"),e.question=""},onError:i=>{console.log(i)}})};return(i,o)=>(r(),n(_,null,[a(t(g),{title:"Ask Gemini"}),a(v,null,{header:l(()=>o[1]||(o[1]=[s("h2",{class:"text-xl font-semibold leading-tight text-gray-800"}," Ask Gemini ",-1)])),default:l(()=>[s("div",y,[s("div",k,[s("div",q,[s("div",V,[o[2]||(o[2]=x(" Ask gemini what you want ")),s("div",A,[s("form",{onSubmit:b(u,["prevent"])},[s("div",null,[f(s("textarea",{"onUpdate:modelValue":o[0]||(o[0]=c=>t(e).question=c),rows:"5",class:w(["input bg-white border-primary block mt-2 w-full max-w-2xl",{"is-invalid":t(e).errors.name}]),type:"text",id:"question"},null,2),[[h,t(e).question]]),t(e).errors.question?(r(),n("span",F,d(t(e).errors.question),1)):m("",!0)]),s("button",{class:"btn btn-primary mt-2",type:"submit",disabled:t(e).processing}," Send ",8,N)],32)]),s("div",S,[i.response?(r(),n("p",B,d(i.response),1)):m("",!0)])])])])])]),_:1})],64))}};export{M as default};
