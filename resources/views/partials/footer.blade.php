<footer class="mt-auto border-t border-navy-900/10 bg-navy-950 text-white">
    <div class="page-container section-padding">
        <div class="grid gap-12 lg:grid-cols-[1.4fr_1fr_1fr_1fr]">
            <div>
                <a href="/hotels" class="flex items-center gap-3">
                    <span class="grid h-11 w-11 place-items-center rounded-2xl bg-gradient-to-br from-gold-500 to-gold-400 text-navy-950">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M4 21V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v16" />
                            <path d="M9 21v-6h6v6" />
                        </svg>
                    </span>
                    <span class="font-display text-2xl font-semibold">StayHub</span>
                </a>
                <p class="mt-5 max-w-sm text-sm leading-relaxed text-white/70">
                    Votre plateforme de réservation hôtelière premium. Des séjours d'exception, partout dans le monde.
                </p>
                <div class="mt-6 flex gap-3">
                    <span class="chip bg-white/10 text-white/90">Paiement sécurisé</span>
                    <span class="chip bg-white/10 text-white/90">Annulation flexible</span>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gold-400">Explorer</h3>
                <ul class="mt-4 space-y-3 text-sm text-white/70">
                    <li><a href="/hotels" class="transition hover:text-white">Tous les hôtels</a></li>
                    <li><a href="/bookings" class="transition hover:text-white">Mes réservations</a></li>
                    <li><a href="/admin" class="transition hover:text-white">Espace admin</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gold-400">Support</h3>
                <ul class="mt-4 space-y-3 text-sm text-white/70">
                    <li><a href="#" class="transition hover:text-white">Centre d'aide</a></li>
                    <li><a href="#" class="transition hover:text-white">Contact</a></li>
                    <li><a href="#" class="transition hover:text-white">FAQ</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gold-400">Newsletter</h3>
                <p class="mt-4 text-sm text-white/70">Recevez nos offres exclusives et inspirations voyage.</p>
                <form class="mt-4 flex gap-2" onsubmit="return false;">
                    <input type="email" placeholder="votre@email.com" class="form-input flex-1 border-white/20 bg-white/10 text-white placeholder:text-white/50" aria-label="Email newsletter">
                    <button type="submit" class="btn-gold shrink-0 px-4">OK</button>
                </form>
            </div>
        </div>

        <div class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-white/10 pt-8 text-sm text-white/50 sm:flex-row">
            <p>&copy; {{ date('Y') }} StayHub. Tous droits réservés.</p>
            <div class="flex gap-6">
                <a href="#" class="hover:text-white">Confidentialité</a>
                <a href="#" class="hover:text-white">Conditions</a>
            </div>
        </div>
    </div>
</footer>
