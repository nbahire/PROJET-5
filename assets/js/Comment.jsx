import { render, unmountComponentAtNode } from 'react-dom'
import React, { useEffect } from 'react'
import { usePaginatedFetch } from './hooks'
import imageUser from './img/user-1.png'


function Comments() {
    const { items: comments, load, loading, count, hasMore } = usePaginatedFetch('/api/comments')
    useEffect(() => { load() }, [])
    return <div >
        <Title count={count} />
        <div className="pl-5 comment-content comment-box">
            {loading && 'Chargement...'}
            {comments.map(c => <Comment key={c.id} comment={c} />)}
        </div>
        {hasMore && < button disabled={loading} className="btn btn-primary " onClick={load}>Charger plus de commentaires</button>}
    </div>
}

function Title({ count }) {
    return <div className="comments-details">
        <span className="total-comments comments-sort">
            {count} Commentaire{count > 1 ? 's' : ''}
        </span>
    </div>
}
function Comment({ comment }) {
    return <div> 
        <span className="commenter-pic">
            <img src='/build/images/user-1.b388bc8a.png' alt="image user"/>
        </span>
        <span className="commenter-name">
        <a className="comment-user" href="#">{comment.users.name}</a>
        <span className="comment-time">{comment.publishedAt}</span>
    </span>
<p className="comment-txt">{comment.content}</p>
    </div>
}
class CommentsElement extends HTMLElement {

    connectedCallback() {
        render(<Comments />, this)
    }
    discnnectedCollback() {
        unmountComponentAtNode(this)
    }
}

customElements.define('post-comments', CommentsElement)