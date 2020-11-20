import { render, unmountComponentAtNode } from 'react-dom'
import React, { useEffect } from 'react'
import { usePaginatedFetch } from './hooks'
import imageUser from './img/user-1.png'


const dateFormat = {
    dateStyle: 'medium',
    timeStyle: 'short',
}

function Comments({ post }) {
    const { items: comments, load, loading, count, hasMore } = usePaginatedFetch('/api/comments?posts=' + post)
    useEffect(() => { load() }, [])
    return <div >
        <Title count={count} />
        {comments.map(c => <Comment key={c.id} comment={c} />)}
        {hasMore && < button disabled={loading} className="btn btn-success " onClick={load}>Charger plus de commentaires</button>}
    </div>
}

function Title({ count }) {
    return <div className="comments-details">
        <span className="total-comments comments-sort">
            {count} Commentaire{count > 1 ? 's' : ''}
        </span>
    </div>
}

const Comment = React.memo(({ comment }) => {
    const date = new Date(comment.publishedAt)
    return <div className="pl-5 ml-5 comment-box">
        <p className="commenter-name">
            Par <a className="comment-user" >{comment.users.name}</a> le<span className="comment-time">{date.toLocaleString(undefined, dateFormat)}</span>
        </p>
        <p className="comment-txt">{comment.content}</p>

    </div>
})
class CommentsElement extends HTMLElement {
    constructor() {
        super()
        this.observer = null
    }
    connectedCallback() {
        const post = parseInt(this.dataset.post, 10)
        if (this.observer === null) {
            this.observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && entry.target === this) {
                        observer.disconnect()
                        render(<Comments post={post} />, this)
                    }
                })
            })

        }
        this.observer.observe(this)
    }

    discnnectedCollback() {
        if (this.observer) {
            this.observer.disconnect()

        }
        unmountComponentAtNode(this)
    }
}

customElements.define('post-comments', CommentsElement)