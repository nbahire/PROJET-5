import { useCallback, useState } from "react"

export function usePaginatedFetch(url){
    const [loading, setLoading]= useState(false)
    const [items,setItems] = useState([])
    const [count, setCount] = useState(0)
    const [next, setNext] = useState(null)
    const load = useCallback(async()=> {
        setLoading(true)
        const responce = await fetch(next || url,{
            headers:{
                'Accept': 'application/ld+json'
            }
        })
        const responseDatas = await responce.json()
        if(responce.ok){
            setItems(items => [...items,...responseDatas['hydra:member']])
            setCount(responseDatas['hydra:totalItems'])
            if (responseDatas['hydra:view'] && responseDatas['hydra:view']['hydra:next']) {
                setNext(responseDatas['hydra:view']['hydra:next']) 
            }else {
                setNext(null)
            }
        }else {
            console.error(responseDatas)
        }
        setLoading(false)
    },[url, next])

    return{
        items,
        load,
        count,
        loading,
        hasMore:next !== null
    }
}